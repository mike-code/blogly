<?php
namespace App\Models;

class BlogEntry extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $collection = 'blog_entries';
    protected $connection = 'mongodb';
}
