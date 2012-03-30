<?php
namespace Models\Comment;

interface ICommentable
{
	/**
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getComments();
	
	/**
	 * @param Models\Comment\Comment
	 */
	public function addComment(Comment $comment);
	
	/**
	 * @param Models\Comment\Comment
	 */
	public function removeComment(Comment $comment);
}