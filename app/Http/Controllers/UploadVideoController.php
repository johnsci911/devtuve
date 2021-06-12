<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class UploadVideoController extends Controller
{
	public function index(Channel $channel)
	{
		return view('channels.upload', [
			'channel' => $channel
		]);
	}
}
