<?php

class ImageModel
{
	private $_database;

    public function __construct(Database $db_instance)
    {
        $this->_database = $db_instance;
	}
	
	public function saveImage($user, $filename, $time)
	{
		$query = "INSERT INTO `images` set `user` = ?, `filename` = ?, `time` = ?";
		if ($this->_database->execute($query, [$user, $filename, $time]))
			return true;
		else
			return false;
	}

	public function deleteImage($filename)
	{
		$query = "DELETE FROM images WHERE `filename` = ?";
		if (!($this->_database->execute($query, [$filename])))
			return FALSE;
		$query = "DELETE FROM likes WHERE `filename` = ?";
		if (!($this->_database->execute($query, [$filename])))
			return FALSE;
			$query = "DELETE FROM comments WHERE `filename` = ?";
		if (!($this->_database->execute($query, [$filename])))
			return FALSE;
		return TRUE;
	}

	public function alreadyLiked($user, $filename)
	{
		$query = "SELECT COUNT(*) FROM likes WHERE `filename` = ? AND `user` = ?";
		if (!($like = $this->_database->select($query, [$filename, $user])))
			return null;
		return ($like['COUNT(*)']);
	}

	public function addLike($user, $filename)
    {
        $query = "INSERT INTO likes SET `filename` = ?, `user` = ? "; 
        if ($this->_database->execute($query, [$filename, $user]))
            return TRUE;
        else
            return FALSE;  
    }

	public function deleteLike($user, $filename)
	{
		$query = "DELETE FROM likes WHERE `filename` = ? AND `user` = ?";
		if ($this->_database->execute($query, [$filename, $user]))
			return TRUE;
		else
			return FALSE;
	}

    public function addComment($comment, $user, $filename)
    {
        $query = "INSERT INTO comments SET `comment` = ?, `user` = ? , `filename` = ?"; 
        if ($this->_database->execute($query, [$comment, $user, $filename]))
            return TRUE;
        return FALSE;  
	}
	
	public function getImages(int $start, int $limit)
	{
		$query = 'SELECT * from images ORDER BY `id` DESC LIMIT'.' '.$start.','.$limit;
		if (!($images = $this->_database->selectAll($query)))
			return null;
		return (count($images) == 0 ? null : $images);
	}

	public function getComments($filename)
	{
		$query = "SELECT * from comments WHERE `filename` = ?  ORDER BY `id` DESC";
		if (!($comments = $this->_database->selectAll($query, [$filename])))
			return null;
		return (count($comments) == 0 ? null : $comments);
	}

	public function getLikeCount($filename)
	{
		$query = "SELECT COUNT(*) FROM likes WHERE `filename` = ?";
		if (!($likes = $this->_database->select($query, [$filename])))
			return null;
		else
			return ($likes['COUNT(*)']);
	}

	public function getImagesCount()
	{
		$query = 'SELECT * from images';
		if (!($images = $this->_database->selectAll($query)))
			return 0;
		return (count($images));
	}

	public function getUserImages($user)
	{
		$query = 'SELECT * from images WHERE user = ?  ORDER BY `time` DESC ';
		if (!($images = $this->_database->selectAll($query, [$user])))
			return null;
		return (count($images) == 0 ? null : $images);	
	}
}
