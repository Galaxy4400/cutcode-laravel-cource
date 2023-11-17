<?php

namespace App\Http\Controllers;

use App\View\ViewModels\CatalogViewModel;
use Domains\Catalog\Models\Category;

class CatalogController extends Controller
{
	public function __invoke(?Category $category): CatalogViewModel
	{
		return CatalogViewModel::make($category)->view('catalog.index');
	}
}
