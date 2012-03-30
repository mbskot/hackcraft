<?php
namespace Models\File;

use Doctrine\ORM\EntityManager,
	Models\BaseModel,
	Models\FileType\FileTypeModel,
	Nette\Http\FileUpload;

class FileModel extends BaseModel
{
	/**	@var Models\FileType\FileTypeModel */
	private $fileTypes;
	
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @param Models\FileType\FileTypeModel
	 * @return Models\File\FileModel
	 */
	public function __construct(EntityManager $entityManager, FileTypeModel $fileTypes)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\File');
		
		$this->fileTypes = $fileTypes;
	}
	
	/**
	 * @param Nette\Http\FileUpload
	 * @return Models\File\File
	 * @throws Models\File\BadFileUploadedException
	 */
	public function upload(FileUpload $fileUpload)
	{
		if(!$fileUpload->isOk())
		{
			throw new BadFileUploadedException('Počas prenosu došlo k poškodeniu súboru!');
		}
		
		$fileType = $this->fileTypes->findOneByMime($fileUpload->contentType);
		
		if(!$fileType)
		{
			throw new BadFileUploadedException('Nepovolený formát súboru(' . $fileUpload->contentType . ')!');
		}
		
		$file = $this->create();
		$file->file = $fileUpload;
		$file->fileType = $fileType;
		
		return $this->save($file);
	}
}