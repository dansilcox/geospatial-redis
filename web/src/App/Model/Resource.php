<?php

declare(strict_types=1);

namespace App\Model;
use JsonSerializable;

class Resource implements JsonSerializable {
  private string $id = '';
  public string $name;
  public float $latitude;
  public float $longitude;
  public float $distance = 0;

  public function __construct(?string $id = null)
  {
    $this->id = $id ?? str_replace('.', '', uniqid('', true));
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function jsonSerialize(): array
  {
    return [
      'id'        => $this->id,
      'name'      => $this->name,
      'latitude'  => $this->latitude,
      'longitude' => $this->longitude,
      'distance'  => $this->distance
    ];
  }
}