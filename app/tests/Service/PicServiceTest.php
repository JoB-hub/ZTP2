<?php
/**
 * Pic service tests.
 */

namespace Service;

use App\Entity\Game;
use App\Entity\Pic;
use App\Repository\PicRepository;
use App\Service\FileUploadServiceInterface;
use App\Service\PicService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * PicServiceTest class.
 */
class PicServiceTest extends TestCase
{
    private string $targetDirectory;
    private PicRepository $picRepository;
    private FileUploadServiceInterface $fileUploadService;
    private Filesystem $filesystem;

    /**
     * Set up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->targetDirectory = '/public/uploads/pics';
        $this->picRepository = $this->createMock(PicRepository::class);
        $this->fileUploadService = $this->createMock(FileUploadServiceInterface::class);
        $this->filesystem = $this->createMock(Filesystem::class);
    }

    /**
     * Test create pic.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $uploadedFile = $this->createMock(UploadedFile::class);

        $pic = new Pic();
        $game = new Game();

        $this->fileUploadService->expects($this->once())
            ->method('upload')
            ->willReturn('new_pic_filename.jpg');

        $picService = new PicService($this->targetDirectory, $this->picRepository, $this->fileUploadService, $this->filesystem);

        $picService->create($uploadedFile, $pic, $game);
    }
}
