<?php
/**
 * Pic service interface.
 */

namespace App\Service;

use App\Entity\Game;
use App\Entity\Pic;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface PicServiceInterface.
 */
interface PicServiceInterface
{
    /**
     * Create pic.
     *
     * @param UploadedFile $uploadedFile Uploaded file
     * @param Pic          $pic          Pic entity
     * @param Game         $game         Game interface
     */
    public function create(UploadedFile $uploadedFile, Pic $pic, Game $game): void;

    /**
     * Update pic.
     *
     * @param UploadedFile $uploadedFile Uploaded file
     * @param Pic          $pic          Pic entity
     * @param Game         $game         Game interface
     */
    public function update(UploadedFile $uploadedFile, Pic $pic, Game $game): void;
}
