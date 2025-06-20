<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Review;
use App\Models\Upload;
use App\Models\Attribute;

class ClassifiedProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {

                $photo_paths = get_images_path($data->photos);

                $photos = [];
                if (!empty($photo_paths)) {
                    for ($i = 0; $i < count($photo_paths); $i++) {
                        if ($photo_paths[$i] != "") {
                            $item = array();
                            $item['variant'] = "";
                            $item['path'] = $photo_paths[$i];
                            $photos[] = $item;
                        }
                    }
                }

                $brand = [
                    'id' => 0,

                    'slug' => "",

                    'name' => "",
                    'logo' => "",
                ];

                if ($data->brand != null) {
                    $brand = [
                        'id' => $data->brand->id,
                        'slug' => $data->brand->slug,
                        'name' => $data->brand->getTranslation('name'),
                        'logo' => uploaded_asset($data->brand->logo),
                    ];
                }


                return [
                    'id' => (int)$data->id,
                    'name' => $data->getTranslation('name'),
                    'added_by' => $data->user->name,
                    'phone' => $data->user->phone ?? "",
                    'condition' => $data->conditon,
                    'photos' =>new UploadedFileCollection(Upload::whereIn("id", explode(",", $data->photos))->get()),
                    'thumbnail_image' =>  new UploadedFileCollection(Upload::whereIn("id", explode(",", $data->thumbnail_img))->get()),
                    'certificate_img' =>  new UploadedFileCollection(Upload::whereIn("id", explode(",", $data->certificate_img))->get()),
                  
                    'tags' => explode(',', $data->tags),
                    'location' =>  $data->location,
                    'unit_price' => single_price($data->unit_price),
                    'unit'   => $data->unit ?? "",
                    'width'  => $data->width ?? "",
                    'height' => $data->height ?? "",
                    'depth'  => $data->depth ?? "",
                    'description' => $data->getTranslation('description'),
                    'video_link' => $data->video_link != null ?  $data->video_link : "",
                    'brand' => $brand,
                    'category' => $data->category->getTranslation('name'),
                    'link' => route("customer.product", $data->slug),
                    'meta_title' => $data->meta_title,
                    'meta_description' => $data->meta_description,
                    'meta_image' =>new UploadedFileCollection(Upload::whereIn("id", explode(",", $data->meta_img))->get()),
                    "pdf" => new UploadedFileCollection(Upload::whereIn("id", explode(",", $data->pdf))->get()),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

    protected function convertToChoiceOptions($data)
    {
        $result = array();
        if ($data) {
            foreach ($data as $key => $choice) {
                $item['name'] = $choice->attribute_id;
                $item['title'] = Attribute::find($choice->attribute_id)->getTranslation('name');
                $item['options'] = $choice->values;
                array_push($result, $item);
            }
        }
        return $result;
    }

    protected function convertPhotos($data)
    {
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, uploaded_asset($item));
        }
        return $result;
    }
}
