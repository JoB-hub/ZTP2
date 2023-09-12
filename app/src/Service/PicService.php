<?php
/**
 * Pic service.
 */

namespace App\Service;

use App\Entity\Pic;
use App\Entity\Game;
use App\Repository\PicRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PicService.
 */
class PicService implements PicServiceInterface
{
    /**
     * Target directory.
     */
    private string $targetDirectory;

    /**
     * Pic repository.
     */
    private PicRepository $picRepository;

    /**
     * File upload service.
     */
    private FileUploadServiceInterface $fileUploadService;

    /**
     * File system service.
     */
    private Filesystem $filesystem;

    /**
     * Constructor.
     *
     * @param string                     $targetDirectory   Target directory
     * @param PicRepository              $picRepository     Pic repository
     * @param FileUploadServiceInterface $fileUploadService File upload service
     * @param Filesystem                 $filesystem        Filesystem component
     */
    public function __construct(string $targetDirectory, PicRepository $picRepository, FileUploadServiceInterface $fileUploadService, Filesystem $filesystem)
    {
        $this->targetDirectory = $targetDirectory;
        $this->picRepository = $picRepository;
        $this->fileUploadService = $fileUploadService;
        $this->filesystem = $filesystem;
    }

    /**
     * Update pic.
     *
     * @param UploadedFile $uploadedFile Uploaded file
     * @param Pic          $pic          Pic entity
     * @param Game         $game         Game entity
     */
    public function update(UploadedFile $uploadedFile, Pic $pic, Game $game): void
    {
        $filename = $pic->getFilename();

        if (null !== $filename) {
            $this->filesystem->remove(
                $this->targetDirectory.'/'.$filename
            );
        }
        $this->create($uploadedFile, $pic, $game);
    }

    /**
     * Create pic.
     *
     * @param UploadedFile $uploadedFile Uploaded file
     * @param Pic          $pic          Pic entity
     * @param Game         $game         Game entity
     */
    public function create(UploadedFile $uploadedFile, Pic $pic, Game $game): void
    {
        $picFilename = $this->fileUploadService->upload($uploadedFile);

        $pic->setGame($game);
        $pic->setFilename($picFilename);
        $this->picRepository->save($pic);
    }
}
