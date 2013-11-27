<?php
/*
 * Copyright (C) 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
//  Author: Jenny Murphy - http://google.com/+JennyMurphy

// TODO: You must configure these fields for the starter project to function.
// Visit https://developers.google.com/glass/getting-started to learn more
$api_client_id = "91469454054.apps.googleusercontent.com";
$api_client_secret = "o_Vfjx6LcIbCJDi3hGbCr3H7";
$api_simple_key = "AIzaSyCp81hY26Dy0nQ79267MSCyythKEv57elY";

$base_url = "https://wildlabglass.appspot.com";

// This should be writable by your web server's user
//$sqlite_database = "/tmp/database.sqlite";

//this is new code for Google Cloud SQL Instance
// $db = new PDO('mysql:unix_socket=/cloudsql/gcdc2013-wildlab:my-cloudsql-instance;charset=utf8',
  // 'wildlab',
  // 'robins1'
// );

$mysqli_db = new mysqli(null, "root", "", null, null, "/cloudsql/gcdc2013-wildlab:database");