<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Entity;

class Video {

    public string $url;
    public string $titulo;
    public int $id;
    private ?string $filePath = null;

    public function __construct($url, $titulo) {
        $this->url = $url;
        $this->titulo = $titulo;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setFilePah(?string $filePath): void {
        $this->filePath = $filePath;
    }

    public function getFilePath(): ?string {
        return $this->filePath;
    }
}