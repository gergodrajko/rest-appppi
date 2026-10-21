<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    /**
     * @api {get} /cities Városok listázása
     * @apiName GetCities
     * @apiGroup City
     * @apiVersion 1.0.0
     * @apiDescription Visszaadja az összes várost a hozzájuk tartozó vármegyével. Névre és vármegyére szűrhető, a két szűrő együtt is használható.
     *
     * @apiQuery {String} [search] Névrészlet, amire szűr (LIKE '%...%')
     * @apiQuery {Number} [countyid] Vármegye azonosítója
     *
     * @apiSuccess {Object[]} cities Városok listája
     * @apiSuccess {Number} cities.id Város azonosítója
     * @apiSuccess {String} cities.name Város neve
     * @apiSuccess {Number} cities.zip_code Irányítószám
     * @apiSuccess {Number} cities.population Lakosságszám
     * @apiSuccess {Number} cities.county_id Vármegye azonosítója
     * @apiSuccess {Object} cities.county Vármegye adatai
     * @apiSuccess {Number} cities.county.id Vármegye azonosítója
     * @apiSuccess {String} cities.county.name Vármegye neve
     * @apiSuccess {String} cities.county.badge_url A vármegye címerének URL-je
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         {
     *           "id": 1,
     *           "name": "Szeged",
     *           "zip_code": 6720,
     *           "population": 160000,
     *           "county_id": 6,
     *           "county": {
     *             "id": 6,
     *             "name": "Csongrád-Csanád",
     *             "badge_url": "https://example.com/badges/csongrad-csanad.png"
     *           }
     *         }
     *       ]
     *     }
     */
    public function index(Request $request){
        $query = City::with('county');

        if($request->filled('search')){
            $query->where('name','LIKE','%'.$request->search.'%');
        }

        if($request->filled('countyid')){
            $query->where('county_id','=',$request->countyid);
        }
        $cities = $query->get();
        return response()->json([
            'cities' => $cities
        ]);
    }

    /**
     * @api {post} /cities Város létrehozása
     * @apiName CreateCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * @apiPermission AuthRequired
     * @apiUse AuthRequired
     *
     * @apiBody {String} name Város neve
     * @apiBody {Number} zip_code Irányítószám
     * @apiBody {Number} population Lakosságszám
     * @apiBody {Number} county_id Vármegye azonosítója (létező vármegye kell)
     *
     * @apiSuccess {Object} city Az új város
     * @apiSuccess {Number} city.id Város azonosítója
     * @apiSuccess {String} city.name Város neve
     * @apiSuccess {Number} city.zip_code Irányítószám
     * @apiSuccess {Number} city.population Lakosságszám
     * @apiSuccess {Number} city.county_id Vármegye azonosítója
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "name": "Makó",
     *         "zip_code": 6900,
     *         "population": 22000,
     *         "county_id": 6,
     *         "id": 2
     *       }
     *     }
     */
    public function store(Request $request){
        $city = City::create($request->all());
        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {get} /cities/:id Város lekérése
     * @apiName GetCity
     * @apiGroup City
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Város azonosítója
     *
     * @apiSuccess {Object} city A város
     * @apiSuccess {Number} city.id Város azonosítója
     * @apiSuccess {String} city.name Város neve
     * @apiSuccess {Number} city.zip_code Irányítószám
     * @apiSuccess {Number} city.population Lakosságszám
     * @apiSuccess {Number} city.county_id Vármegye azonosítója
     * @apiSuccess {Object} city.county Vármegye adatai
     * @apiSuccess {Number} city.county.id Vármegye azonosítója
     * @apiSuccess {String} city.county.name Vármegye neve
     * @apiSuccess {String} city.county.badge_url A vármegye címerének URL-je
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 1,
     *         "name": "Szeged",
     *         "zip_code": 6720,
     *         "population": 160000,
     *         "county_id": 6,
     *         "county": {
     *           "id": 6,
     *           "name": "Csongrád-Csanád",
     *           "badge_url": "https://example.com/badges/csongrad-csanad.png"
     *         }
     *       }
     *     }
     *
     * @apiUse NotFound
     */
    public function show($id){
        $city = City::with('county')->findOrFail($id);
        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {put} /cities/:id Város módosítása
     * @apiName UpdateCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * @apiPermission AuthRequired
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id Város azonosítója
     *
     * @apiBody {String} [name] Város neve
     * @apiBody {Number} [zip_code] Irányítószám
     * @apiBody {Number} [population] Lakosságszám
     * @apiBody {Number} [county_id] Vármegye azonosítója
     *
     * @apiSuccess {Object} city A módosított város
     * @apiSuccess {Number} city.id Város azonosítója
     * @apiSuccess {String} city.name Város neve
     * @apiSuccess {Number} city.zip_code Irányítószám
     * @apiSuccess {Number} city.population Lakosságszám
     * @apiSuccess {Number} city.county_id Vármegye azonosítója
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 2,
     *         "name": "Makó",
     *         "zip_code": 6900,
     *         "population": 21500,
     *         "county_id": 6
     *       }
     *     }
     *
     * @apiUse NotFound
     */
    public function update(Request $request, $id){
        $city = City::findOrFail($id);
        $city->update($request->all());
        return response()->json([
            'city' => $city
        ]);
    }

    /**
     * @api {delete} /cities/:id Város törlése
     * @apiName DeleteCity
     * @apiGroup City
     * @apiVersion 1.0.0
     * @apiPermission AuthRequired
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id Város azonosítója
     *
     * @apiSuccess {String} message Visszajelzés
     * @apiSuccess {Number} id A törölt város azonosítója
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "City deleted successfully!",
     *       "id": "2"
     *     }
     *
     * @apiUse NotFound
     */
    public function destroy($id){
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json([
            'message' => "City deleted successfully!",
            'id' => $id
        ]);
    }

    /**
     * @api {get} /counties/:id/cities Vármegye városai
     * @apiName GetCitiesByCounty
     * @apiGroup City
     * @apiVersion 1.0.0
     * @apiDescription Egy vármegye összes városa. Ha a vármegye nem létezik, üres listát ad vissza (nem 404-et).
     *
     * @apiParam {Number} id Vármegye azonosítója
     *
     * @apiSuccess {Object[]} cities A vármegye városai
     * @apiSuccess {Number} cities.id Város azonosítója
     * @apiSuccess {String} cities.name Város neve
     * @apiSuccess {Number} cities.zip_code Irányítószám
     * @apiSuccess {Number} cities.population Lakosságszám
     * @apiSuccess {Number} cities.county_id Vármegye azonosítója
     *
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         { "id": 1, "name": "Szeged", "zip_code": 6720, "population": 160000, "county_id": 6 },
     *         { "id": 2, "name": "Makó", "zip_code": 6900, "population": 22000, "county_id": 6 }
     *       ]
     *     }
     */
    public function getCitiesByCounty($countyId){
        $cities = City::where('county_id', $countyId)->get();
        return response()->json([
            'cities' => $cities
        ]);
    }
}
