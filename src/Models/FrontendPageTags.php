<?php

namespace Sahakavatar\Manage\Models;

use Illuminate\Database\Eloquent\Model;


class FrontendPageTags extends Model {
	/**
	 * @var string
	 */
	protected $table = 'frontend_pages_tags';
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $guarded = ['created_at'];
}
