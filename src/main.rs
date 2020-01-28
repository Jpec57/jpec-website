#![feature(proc_macro_hygiene, decl_macro)]

#[macro_use]
extern crate rocket;

pub mod cors;

use rocket::response::content;
// use rocket::http::Method; // 1.

// use rocket_cors::{
//     AllowedHeaders, AllowedOrigins, Error, // 2.
//     Cors, CorsOptions // 3.
// };

// fn make_cors() -> Cors {
//     let allowed_origins = AllowedOrigins::some_exact(&[ // 4.
//         "http://localhost:8080",
//         "http://127.0.0.1:8080",
//         "http://localhost:8000",
//         "http://0.0.0.0:8000",
//     ]);

//     CorsOptions { // 5.
//         allowed_origins,
//         allowed_methods: vec![Method::Get].into_iter().map(From::from).collect(), // 1.
//         allowed_headers: AllowedHeaders::some(&[
//             "Authorization",
//             "Accept",
//             "Access-Control-Allow-Origin", // 6.
//         ]),
//         allow_credentials: true,
//         ..Default::default()
//     }
//     .to_cors()
//     .expect("error while building CORS")
// }


#[get("/")]
fn index() -> &'static str {
    "Hello Jpec!"
}

#[get("/home")]
fn home_index() -> &'static str {
    "Welcome home"
}


#[get("/data")]
fn json() -> content::Json<&'static str> {
    content::Json("{ 'hi': 'world' }")
}

fn main() {
    rocket::ignite()
    .mount("/", routes![index])
    .mount("/", routes![home_index])
    .mount("/", routes![json])
    // .attach(make_cors()) 
    .attach(cors::CorsFairing) // Add this line
    .launch();
}
