#!/bin/bash
# ============================================================
# FIX: Add KYC, Notifications, Platform Health to Admin Sidebar
# Run in Bluehost cPanel Terminal
# ============================================================

cd ~/public_html

echo "=== Adding EWA Operations to admin sidebar ==="

# Check if already added
if grep -q "EWA Operations" resources/views/layouts/menu.blade.php; then
    echo "  ✓ EWA Operations menu already exists"
else
    # Insert after @endcan (first occurrence, after dashboard)
    cat > /tmp/ewa_menu_patch.php << 'EOF'
<?php
$file = 'resources/views/layouts/menu.blade.php';
$content = file_get_contents($file);

$menuItems = '
<!-- EWA Operations -->
<li class="nav-header">EWA Operations</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is(\'admin/kyc*\') ? \'active\' : \'\' }}" href="{!! url(\'admin/kyc\') !!}">@if($icons)
            <i class="nav-icon fas fa-id-card"></i>
        @endif
        <p>KYC Verification
            @php
                $pendingKyc = \\App\\Models\\EProvider::where(\'kyc_status\', \'pending\')->count();
            @endphp
            @if($pendingKyc > 0)
                <span class="right badge badge-warning">{{ $pendingKyc }}</span>
            @endif
        </p></a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is(\'admin/notifications*\') ? \'active\' : \'\' }}" href="{!! url(\'admin/notifications\') !!}">@if($icons)
            <i class="nav-icon fas fa-bell"></i>
        @endif
        <p>Notifications Centre</p></a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is(\'admin/platform-health*\') ? \'active\' : \'\' }}" href="{!! url(\'admin/platform-health\') !!}">@if($icons)
            <i class="nav-icon fas fa-heartbeat"></i>
        @endif
        <p>Platform Health</p></a>
</li>
';

// Find the first @endcan and insert after it
$pos = strpos($content, '@endcan');
if ($pos !== false) {
    $endPos = $pos + strlen('@endcan');
    $content = substr($content, 0, $endPos) . "\n" . $menuItems . substr($content, $endPos);
    file_put_contents($file, $content);
    echo "Menu items added successfully!\n";
} else {
    echo "Could not find insertion point\n";
}
EOF
    php /tmp/ewa_menu_patch.php
    rm -f /tmp/ewa_menu_patch.php
    echo "  ✓ EWA Operations menu added"
fi

echo ""
echo "=== Clearing view cache ==="
php artisan view:clear 2>&1
php artisan cache:clear 2>&1

echo ""
echo "✅ Admin sidebar updated!"
echo ""
echo "New sidebar items:"
echo "  • KYC Verification (with pending badge)"
echo "  • Notifications Centre"
echo "  • Platform Health"
