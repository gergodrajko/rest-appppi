<?php

// Közös apidoc definíciók. Ebben a fájlban nincs futtatandó kód,
// csak újrahasznosítható dokumentációs blokkok vannak.

/**
 * @apiDefine AuthRequired Bejelentkezés szükséges
 * A végpont csak érvényes Bearer tokennel hívható (lásd: Login).
 *
 * @apiHeader {String} Authorization Bearer token a login végpontról (pl. `Bearer 1|abcdef...`)
 *
 * @apiError (401) Unauthenticated Hiányzó vagy érvénytelen token
 *
 * @apiErrorExample {json} 401 Unauthenticated:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "message": "Unauthenticated."
 *     }
 */

/**
 * @apiDefine NotFound A rekord nem található
 *
 * @apiError (404) NotFound A megadott azonosítóval nincs rekord
 *
 * @apiErrorExample {json} 404 Not Found:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "message": "No query results for model [App\\Models\\City] 99"
 *     }
 */
