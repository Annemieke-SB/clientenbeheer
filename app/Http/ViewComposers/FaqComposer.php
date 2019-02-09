<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Faqs;

class FaqComposer {

	public function compose($view) {
		$view->with('faqs', Faqs::all());
	
	}
}