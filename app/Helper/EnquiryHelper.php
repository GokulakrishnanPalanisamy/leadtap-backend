<?php

namespace App\Helper;


use App\Models\Enquiry;

class EnquiryHelper
{
    public static function checkDataPresentwithin24Hours($data)
    {
        return Enquiry::where('email', $data['email'])
            ->where('phone', $data['phone'])
            ->where('wp_post_id', $data['wp_post_id'])
            ->where(
                'created_at',
                '>=',
                now()->subDay()
            )
            ->exists();
    }
}
