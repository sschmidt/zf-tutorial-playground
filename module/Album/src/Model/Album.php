<?php

namespace Album\Model;

class Album
{
    public $id;
    public $artist;
    public $title;

    public function exchangeArray(array $data)
    {
        $this->id     = $data['id'] ?? null;
        $this->artist = $data['artist'] ?? null;
        $this->title  = $data['title'] ?? null;
    }
}
