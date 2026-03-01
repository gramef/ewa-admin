<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;

/**
 * Class EProviderPayout
 * @package App\Models
 * @version January 30, 2021, 11:17 am UTC
 *
 * @property EProvider eProvider
 * @property integer e_provider_id
 * @property string method
 * @property double amount
 * @property Date paid_date
 * @property string note
 * @property integer id
 * @property string|null full_name  
 * @property string|null bank_name  
 * @property string|null account_number  
 * @property string|null iban  
 * @property string|null sort_code
 * @property string|null currency  
 * @property string|null receipt_file_path 
 */
class EProviderPayout extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'earning_id' => 'nullable|exists:earnings,id',
        'e_provider_id' => 'required|exists:e_providers,id',
        'method' => 'required',
        'amount' => 'required|numeric|min:0.01|max:99999999.99',
        'full_name' => 'nullable|string',
        'bank_name' => 'nullable|string',
        'account_number' => 'nullable|string',
        'iban' => 'nullable|string',
        'sort_code' => 'nullable|string',
        'receipt_file_path' => 'nullable|string',
        'paid'=> 'boolean',
    ];

    public $table = 'e_provider_payouts';

    public $fillable = [
        'earning_id',
        'e_provider_id',
        'method',
        'amount',
        'paid_date',
        'note',
        'full_name',          
        'bank_name',          
        'account_number',    
        'iban',              
        'sort_code',
        'receipt_pdf',
        'paid'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'earning_id' => 'integer',
        'e_provider_id' => 'integer',
        'method' => 'string',
        'amount' => 'double',
        'paid_date' => 'datetime',
        'note' => 'string',
        'full_name' => 'string',          
        'bank_name' => 'string',          
        'account_number' => 'string',    
        'iban' => 'string',              
        'sort_code' => 'string',
        'receipt_pdf' => 'string',
        'paid' => 'boolean',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
    ];

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class, setting('custom_field_models', []));
        if (!$hasCustomField) {
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields', 'custom_fields.id', '=', 'custom_field_values.custom_field_id')
            ->where('custom_fields.in_table', '=', true)
            ->get()->toArray();

        return convertToAssoc($array, 'name');
    }

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    /**
     * @return BelongsTo
     **/
    public function eProvider(): BelongsTo
    {
        return $this->belongsTo(EProvider::class, 'e_provider_id', 'id');
    }
    /**
     * @return BelongsTo
     **/
    public function earning(): BelongsTo
    {
        return $this->belongsTo(Earning::class,'earning_id','id');
    }
}
