<?php

namespace App\Modules\Sonet\Requests;

abstract class SonetRequest extends \App\Http\Requests\ApiRequest
{
    /**
     * Translations for the Sonet attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [

            'category_id'           => trans('Sonet::attributes.category'),
            'folder_id'             => trans('Sonet::attributes.folder'),
            'attachments.*'         => trans('Sonet::attributes.attachment'),
            'attachments.*.title'   => trans('Sonet::attributes.title'),
            'attachments.*.path'    => trans('Sonet::attributes.path'),

        ];
    }
}
