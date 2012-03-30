<?php
namespace Models\Tag;

interface ITagable
{
	/**
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getTags();
	
	/**
	 * @param array
	 */
	public function setTags(array $tags);
}