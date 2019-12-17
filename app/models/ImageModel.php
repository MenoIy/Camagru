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
		$query = "SELECT * from comments WHERE `filename` = ?  ORDER BY `id` DESC";
		$comments = $this->_database->selectAll($query, [$image]);
		return $comments;	
	}

	public function getLikeCount($filename)
    {
        $query = "SELECT COUNT(*) FROM likes WHERE `filename` = ?";
        $like = $this->_database->select($query, [$filename]);
        if (!$like)
            return null;
        else
            return ($like['COUNT(*)']);
	}
	
	public function AlreadyLiked($user, $filename)
	{
		$query = "SELECT COUNT(*) FROM likes WHERE `filename` = ? AND `user` = ?";
        $like = $this->_database->select($query, [$filename, $user]);
        if (!$like)
            return null;
        else
            return ($like['COUNT(*)']);	
	}

}
