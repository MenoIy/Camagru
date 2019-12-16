<?php

class ImageModel
{
	private $_database;

    public function __construct(Database $db_instance)
    {
        $this->_database = $db_instance;
	}
	
	public function getImages()
	{   
		$this->_database->execute("Use db_camagru", ['']);
		$query = 'SELECT * from images';
		$images = $this->_database->selectAll($query);
		return $images;
	}

	public function getComments($image)
	{
		$this->_database->execute("Use db_camagru", ['']);
		$query = "SELECT * from comments WHERE `filename` = ?";
		$comments = $this->_database->selectAll($query, [$image]);
		return $comments;	
	}
}
