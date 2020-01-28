#![feature(proc_macro_hygiene, decl_macro)]

#[macro_use] extern crate rocket;
#[macro_use] extern crate rocket_contrib;
// #[macro_use] extern crate serde_derive;
pub mod cors;

use rocket::response::content;
use rocket_contrib::json::{JsonValue};


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


#[get("/json")]
fn get_json() -> JsonValue {
    json!({
        "id": 83,
        "values": [1, 2, 3, 4]
    })
}

fn main() {
    rocket::ignite()
    .mount("/", routes![index, home_index, json])
    .mount("/", routes![get_json])
    .attach(cors::CorsFairing)
    .launch();
}
