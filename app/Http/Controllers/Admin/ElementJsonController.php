<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ElementJsonController extends Controller
{
    /**
     * @param $element
     *
     * @return View|Factory|JsonResponse|Application
     */
    public function index($element): View|Factory|JsonResponse|Application
    {
        try {
            $elements = getAllElements();
            $schema = getElementSchema($element);

            return view('admin.element.show', compact('schema', 'elements'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering editor']);
        }
    }

    public function save()
    {
        try {
            $data = request()->get('data');
            $element = $data['name'];

            $jsonSchema = readElementJsonSchema();

            if (array_key_exists($element, $jsonSchema)) {
                $jsonSchema[$element] = $data;
            }
            file_put_contents(storage_path() . '/app/data/elementJsonSchema.json', json_encode($jsonSchema, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

            return response()->json(['success' => true, 'message' => 'Updated successfully']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while updating json file']);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while updating json file']);
        }
    }
}
