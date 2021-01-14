<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=> strip_tags($this->description),
            'phone'=>$this->phone ?? ( isset($this->raw['phone']) ? $this->raw['phone'] : ''   ),
            'website'=>$this->website ?? '',
            'links'=>$this->links($this),
            'images'=>$this->images($this)
        ];
    }

    public function links($request){
        $links = [];
        if( isset($this->data['zomatolink']) && $this->data['zomatolink'] ){ $links['zomato'] = $this->data['zomatolink'];}
        if( isset($this->data['swiggylink']) && $this->data['swiggylink'] ){$links['swiggy'] = $this->data['swiggylink'];}
        if( isset($this->data['tripadvisorlink']) && $this->data['tripadvisorlink'] ){$links['tripadvisor'] = $this->data['tripadvisorlink'];}
        if( isset($this->data['facebooklink']) && $this->data['facebooklink'] ){$links['facebook'] = $this->data['facebooklink'];}
        if( isset($this->data['twitterlink']) && $this->data['twitterlink'] ){$links['twitter'] = $this->data['twitterlink'];}
        if( isset($this->data['instagramlink']) && $this->data['instagramlink'] ){$links['instagram'] = $this->data['instagramlink'];}
        if( isset($this->data['linkedinlink']) && $this->data['linkedinlink'] ){$links['linkedin'] = $this->data['linkedinlink'];}
        if( isset($this->data['practolink']) && $this->data['practolink'] ){$links['practo'] = $this->data['practolink'];}
        return $links;
    }

    public function images($request)
    {
        $images = [];
        if( isset($this->data['content_img'])){ $images[] = $this->data['content_img'];}
        if( isset($this->data['galleryimg1'])){ $images[] = $this->data['galleryimg1'];}
        if( isset($this->data['galleryimg2'])){ $images[] = $this->data['galleryimg2'];}
        if( isset($this->data['galleryimg3'])){ $images[] = $this->data['galleryimg3'];}
        if( isset($this->data['galleryimg4'])){ $images[] = $this->data['galleryimg4'];}
        if( isset($this->data['galleryimg5'])){ $images[] = $this->data['galleryimg5'];}
        if( isset($this->data['galleryimg6'])){ $images[] = $this->data['galleryimg6'];}
        if( isset($this->data['galleryimg7'])){ $images[] = $this->data['galleryimg7'];}
        if( isset($this->data['galleryimg8'])){ $images[] = $this->data['galleryimg8'];}
        if( isset($this->data['galleryimg9'])){ $images[] = $this->data['galleryimg9'];}
        return $images;
    }
}
