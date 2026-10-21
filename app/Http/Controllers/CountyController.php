<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;

class CountyController extends Controller
{
    /**
     * @api {get} /counties Vármegyék listázása
     * @apiName GetCounties
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiQuery {String} [search] Névrészlet, amire szűr (LIKE '%...%')
     *
     * @apiSuccess {Object[]} counties Vármegyék listája
     * @apiSuccess {Number} counties.id Vármegye azonosítója
     * @apiSuccess {String} counties.name Vármegye neve
     * @apiSuccess {String} counties.badge_url A vármegye címerének URL-je
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "counties": [
     *         { "id": 1, "name": "Bács-Kiskun", "badge_url": "https://example.com/badges/bacs-kiskun.png" },
     *         { "id": 2, "name": "Baranya", "badge_url": "https://example.com/badges/baranya.png" }
     *       ]
     *     }
     */
    public function index(Request $request){
        $query = County::query();
        if($request->filled('search')){
            $query->where('name','LIKE','%'.$request->search.'%');
        }
        $counties = $query->get();
        return response()->json([
            'counties' => $counties
        ]);
    }

    /**
     * @api {post} /counties Vármegye létrehozása
     * @apiName CreateCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * @apiPermission AuthRequired
     * @apiUse AuthRequired
     *
     * @apiBody {String} name Vármegye neve
     * @apiBody {String} badge_url A vármegye címerének URL-je
     *
     * @apiSuccess {Object} county Az új vármegye
     * @apiSuccess {Number} county.id Vármegye azonosítója
     * @apiSuccess {String} county.name Vármegye neve
     * @apiSuccess {String} county.badge_url A vármegye címerének URL-je
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "name": "Fejér",
     *         "badge_url": "https://example.com/badges/fejer.png",
     *         "id": 3
     *       }
     *     }
     */
    public function store(Request $request){
        $county = County::create($request->all());
        return response()->json([
            'county' => $county
        ]);
    }

    /**
     * @api {get} /counties/:id Vármegye lekérése
     * @apiName GetCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Vármegye azonosítója
     *
     * @apiSuccess {Object} county A vármegye
     * @apiSuccess {Number} county.id Vármegye azonosítója
     * @apiSuccess {String} county.name Vármegye neve
     * @apiSuccess {String} county.badge_url A vármegye címerének URL-je
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "id": 2,
     *         "name": "Baranya",
     *         "badge_url": "https://example.com/badges/baranya.png"
     *       }
     *     }
     *
     * @apiUse NotFound
     */
    public function show($id){
        $county = County::findOrFail($id);
        return response()->json([
            'county' => $county
        ]);
    }

    /**
     * @api {put} /counties/:id Vármegye módosítása
     * @apiName UpdateCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * @apiPermission AuthRequired
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id Vármegye azonosítója
     *
     * @apiBody {String} [name] Vármegye neve
     * @apiBody {String} [badge_url] A vármegye címerének URL-je
     *
     * @apiSuccess {Object} county A módosított vármegye
     * @apiSuccess {Number} county.id Vármegye azonosítója
     * @apiSuccess {String} county.name Vármegye neve
     * @apiSuccess {String} county.badge_url A vármegye címerének URL-je
     *
     * @apiUse NotFound
     */
    public function update(Request $request, $id){
        $county = County::findOrFail($id);
        $county->update($request->all());
        return response()->json([
            'county' => $county
        ]);
    }

    /**
     * @api {delete} /counties/:id Vármegye törlése
     * @apiName DeleteCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     * @apiDescription Törlésnél a vármegyéhez tartozó összes város is törlődik (cascade).
     * @apiPermission AuthRequired
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id Vármegye azonosítója
     *
     * @apiSuccess {String} message Visszajelzés
     * @apiSuccess {Number} id A törölt vármegye azonosítója
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "County deleted successfully!",
     *       "id": "3"
     *     }
     *
     * @apiUse NotFound
     */
    public function destroy($id){
        $county = County::findOrFail($id);
        $county->delete();
        return response()->json([
            'message' => "County deleted successfully!",
            'id' => $id
        ]);
    }
}
