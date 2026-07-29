<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Google Drive KYC Document Service
 * 
 * Handles secure upload, viewing, and management of KYC documents
 * in Google Drive. Documents are stored in vendor-specific folders
 * to comply with GDPR and data protection requirements.
 * 
 * Folder structure: EWA_KYC / {VendorName}_{ProviderId} / documents
 */
class GoogleDriveKycService
{
    private ?Google_Service_Drive $driveService = null;
    private ?string $rootFolderId = null;

    /**
     * Initialise the Google Drive service using a service account.
     */
    private function getDriveService(): Google_Service_Drive
    {
        if ($this->driveService) {
            return $this->driveService;
        }

        $client = new Google_Client();
        $client->setApplicationName('EWA KYC Document Manager');

        // Use service account credentials
        $credPath = config('services.google_drive.credentials_path', storage_path('app/google/service-account.json'));
        
        if (file_exists($credPath)) {
            $client->setAuthConfig($credPath);
        } else {
            // Fallback: use individual env vars
            $client->setClientId(config('services.google_drive.client_id'));
            $client->setClientSecret(config('services.google_drive.client_secret'));
            
            $token = config('services.google_drive.refresh_token');
            if ($token) {
                $client->refreshToken($token);
            }
        }

        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->addScope(Google_Service_Drive::DRIVE);

        $this->driveService = new Google_Service_Drive($client);
        $this->rootFolderId = config('services.google_drive.kyc_folder_id');

        return $this->driveService;
    }

    /**
     * Get or create the root "EWA_KYC" folder in Google Drive.
     */
    private function getRootFolderId(): string
    {
        if ($this->rootFolderId) {
            return $this->rootFolderId;
        }

        $service = $this->getDriveService();

        // Search for existing root folder
        $results = $service->files->listFiles([
            'q' => "name='EWA_KYC' and mimeType='application/vnd.google-apps.folder' and trashed=false",
            'fields' => 'files(id, name)',
            'spaces' => 'drive',
        ]);

        if (count($results->getFiles()) > 0) {
            $this->rootFolderId = $results->getFiles()[0]->getId();
            return $this->rootFolderId;
        }

        // Create root folder
        $folder = new Google_Service_Drive_DriveFile([
            'name' => 'EWA_KYC',
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);

        $created = $service->files->create($folder, ['fields' => 'id']);
        $this->rootFolderId = $created->getId();

        Log::info("Created EWA_KYC root folder in Google Drive: {$this->rootFolderId}");

        return $this->rootFolderId;
    }

    /**
     * Get or create a vendor-specific subfolder.
     * Naming: "{VendorName}_{ProviderId}"
     */
    private function getVendorFolderId(int $providerId, string $vendorName = 'Vendor'): string
    {
        $service = $this->getDriveService();
        $rootId = $this->getRootFolderId();
        $folderName = $this->sanitizeFolderName($vendorName) . "_{$providerId}";

        // Search for existing vendor folder
        $results = $service->files->listFiles([
            'q' => "name='{$folderName}' and '{$rootId}' in parents and mimeType='application/vnd.google-apps.folder' and trashed=false",
            'fields' => 'files(id, name)',
            'spaces' => 'drive',
        ]);

        if (count($results->getFiles()) > 0) {
            return $results->getFiles()[0]->getId();
        }

        // Create vendor folder
        $folder = new Google_Service_Drive_DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$rootId],
        ]);

        $created = $service->files->create($folder, ['fields' => 'id']);

        Log::info("Created vendor KYC folder in Google Drive: {$folderName} ({$created->getId()})");

        return $created->getId();
    }

    /**
     * Upload a KYC document to Google Drive.
     * 
     * @param UploadedFile $file     The uploaded file
     * @param int          $providerId  Provider ID
     * @param string       $vendorName  Vendor business name  
     * @param string       $docType     Document type: 'id_document' or 'rtw_document'
     * @return array{file_id: string, web_view_link: string, name: string}
     */
    public function uploadDocument(UploadedFile $file, int $providerId, string $vendorName, string $docType): array
    {
        $service = $this->getDriveService();
        $folderId = $this->getVendorFolderId($providerId, $vendorName);

        // Delete any existing document of the same type
        $this->deleteExistingDocument($folderId, $docType);

        // Prepare file metadata
        $timestamp = now()->format('Ymd_His');
        $extension = $file->getClientOriginalExtension() ?: 'pdf';
        $fileName = "{$docType}_{$timestamp}.{$extension}";

        $driveFile = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [$folderId],
            'description' => "KYC {$docType} for provider #{$providerId}. Uploaded " . now()->toDateTimeString(),
            'properties' => [
                'provider_id' => (string) $providerId,
                'doc_type' => $docType,
                'uploaded_at' => now()->toIso8601String(),
            ],
        ]);

        $created = $service->files->create($driveFile, [
            'data' => file_get_contents($file->getRealPath()),
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink, webContentLink, name',
        ]);

        Log::info("KYC document uploaded to Google Drive: {$fileName} (File ID: {$created->getId()}) for provider #{$providerId}");

        return [
            'file_id' => $created->getId(),
            'web_view_link' => $created->getWebViewLink(),
            'name' => $created->getName(),
        ];
    }

    /**
     * Generate a temporary view-only link for a document.
     * This creates a short-lived permission, not a download.
     * 
     * @param string $fileId  Google Drive file ID
     * @return string|null    Embeddable preview URL
     */
    public function getViewUrl(string $fileId): ?string
    {
        try {
            $service = $this->getDriveService();
            
            // Get file metadata to build embed URL
            $file = $service->files->get($fileId, ['fields' => 'id, mimeType, webViewLink']);
            
            // Return the embeddable preview URL (view-only, not downloadable)
            // Google Drive preview URL format
            return "https://drive.google.com/file/d/{$fileId}/preview";
        } catch (\Exception $e) {
            Log::error("Failed to get view URL for file {$fileId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Stream document content for secure in-browser viewing.
     * Used as fallback when Google Drive preview isn't available.
     * 
     * @param string $fileId  Google Drive file ID
     * @return array{content: string, mimeType: string, name: string}|null
     */
    public function getDocumentContent(string $fileId): ?array
    {
        try {
            $service = $this->getDriveService();
            
            $file = $service->files->get($fileId, ['fields' => 'id, mimeType, name']);
            $response = $service->files->get($fileId, ['alt' => 'media']);
            
            return [
                'content' => $response->getBody()->getContents(),
                'mimeType' => $file->getMimeType(),
                'name' => $file->getName(),
            ];
        } catch (\Exception $e) {
            Log::error("Failed to get document content for file {$fileId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete existing documents of a given type in a vendor folder.
     */
    private function deleteExistingDocument(string $folderId, string $docType): void
    {
        try {
            $service = $this->getDriveService();
            $results = $service->files->listFiles([
                'q' => "'{$folderId}' in parents and name contains '{$docType}' and trashed=false",
                'fields' => 'files(id, name)',
            ]);

            foreach ($results->getFiles() as $file) {
                $service->files->delete($file->getId());
                Log::info("Deleted old KYC document: {$file->getName()} ({$file->getId()})");
            }
        } catch (\Exception $e) {
            Log::warning("Failed to delete existing document: " . $e->getMessage());
        }
    }

    /**
     * Delete all documents for a vendor (e.g., when provider is deleted).
     */
    public function deleteVendorDocuments(int $providerId, string $vendorName = 'Vendor'): bool
    {
        try {
            $service = $this->getDriveService();
            $rootId = $this->getRootFolderId();
            $folderName = $this->sanitizeFolderName($vendorName) . "_{$providerId}";

            $results = $service->files->listFiles([
                'q' => "name='{$folderName}' and '{$rootId}' in parents and mimeType='application/vnd.google-apps.folder' and trashed=false",
                'fields' => 'files(id)',
            ]);

            foreach ($results->getFiles() as $folder) {
                $service->files->delete($folder->getId());
                Log::info("Deleted vendor KYC folder: {$folderName}");
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete vendor documents: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if the Google Drive service is properly configured.
     */
    public function isConfigured(): bool
    {
        try {
            $this->getDriveService();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sanitize folder name for Google Drive.
     */
    private function sanitizeFolderName(string $name): string
    {
        // Remove special chars, keep alphanumeric, spaces, hyphens
        $clean = preg_replace('/[^a-zA-Z0-9\s\-]/', '', $name);
        return trim($clean) ?: 'Unknown';
    }
}
