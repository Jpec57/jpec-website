#![feature(proc_macro_hygiene, decl_macro)]

#[macro_use]
extern crate rocket;

pub mod cors;

use rocket::response::content;

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
