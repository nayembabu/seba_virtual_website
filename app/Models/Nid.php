<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * NID card records (table `nids`).
 *
 * MySQL (run manually when not using migrations):
 *
 * CREATE TABLE `nids` (
 *   `id` bigint unsigned NOT NULL AUTO_INCREMENT,
 *   `user_id` bigint unsigned NOT NULL,
 *   `signature` varchar(255) DEFAULT NULL,
 *   `photo` varchar(255) DEFAULT NULL,
 *   `nid_number` varchar(50) DEFAULT NULL,
 *   `pin_number` varchar(255) DEFAULT NULL,
 *   `name_en` varchar(255) DEFAULT NULL,
 *   `name_bn` varchar(255) DEFAULT NULL,
 *   `date_of_birth` date DEFAULT NULL,
 *   `birth_place` varchar(255) DEFAULT NULL,
 *   `father_name` varchar(255) DEFAULT NULL,
 *   `mother_name` varchar(255) DEFAULT NULL,
 *   `gender` varchar(20) DEFAULT NULL,
 *   `blood_group` varchar(10) DEFAULT NULL,
 *   `issue_date` date DEFAULT NULL,
 *   `address` text,
 *   `type` varchar(32) NOT NULL DEFAULT 'nid',
 *   `present_address` text,
 *   `spouse_name` varchar(255) DEFAULT NULL,
 *   `education` varchar(255) DEFAULT NULL,
 *   `religion` varchar(100) DEFAULT NULL,
 *   `occupation` varchar(255) DEFAULT NULL,
 *   `vote_center` varchar(255) DEFAULT NULL,
 *   `voter_no` varchar(100) DEFAULT NULL,
 *   `form_no` varchar(100) DEFAULT NULL,
 *   `created_at` timestamp NULL DEFAULT NULL,
 *   `updated_at` timestamp NULL DEFAULT NULL,
 *   PRIMARY KEY (`id`),
 *   KEY `nids_user_id_index` (`user_id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 */
class Nid extends Model
{
    use HasFactory;

    public const TYPE_NID = 'nid';

    public const TYPE_APPLICATION = 'application';

    public const TYPE_SIGN_TO_SERVER = 'sign-to-server';

    public const TYPE_CDMS = 'cdms';

    protected $fillable = [
        'user_id',
        'signature', // types: nid, application
        'photo',
        'nid_number',
        'pin_number',
        'name_en',
        'name_bn',
        'date_of_birth',
        'birth_place',
        'father_name',
        'mother_name',
        'gender',
        'blood_group',
        'issue_date',
        'address',
        'type', // nid | application | sign-to-server | cdms
        'present_address', // types: cdms, sign-to-server
        'spouse_name', // types: cdms, sign-to-server
        'education', // types: cdms, sign-to-server
        'religion', // types: cdms, sign-to-server
        'occupation', // types: cdms, sign-to-server
        'vote_center', // type: cdms
        'voter_no', // type: cdms
        'form_no', // type: cdms
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'issue_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
