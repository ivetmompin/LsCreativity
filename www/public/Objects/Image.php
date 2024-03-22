<?php

namespace Ivet\Ac1\Objects;
class Image
{
    private string $src;
    private string $description;
    private string $likes;

    public function __construct($image)
    {
        $this->src = $image['urls']['regular'];
        if ($image['description'] != null) {
            $this->description = $image['description'];
        } else {
            $this->description = "none";
        }
        $this->likes = $image['likes'];
    }

    public function retrieveSrc(): string
    {
        return $this->src;
    }

    public function retrieveDescription(): string
    {
        return $this->description;
    }

    public function retrieveLikes(): string
    {
        return $this->likes;
    }

}