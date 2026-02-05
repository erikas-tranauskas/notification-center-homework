<?php

namespace App\Response\Notification;

class Notification
{
    private string $title = '';
    private string $description = '';
    private string $ctaUrl = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCtaUrl(): ?string
    {
        return $this->ctaUrl;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setCtaUrl(?string $ctaUrl): self
    {
        $this->ctaUrl = $ctaUrl;

        return $this;
    }
}
