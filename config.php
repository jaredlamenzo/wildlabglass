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

//https://cloud.google.com/console?redirected=true#/project/apps~wildlabglass/apiui/app/WEB/91469454054-nd2tbk1lfhnjti4rbhgljulv0m0orcir.apps.googleusercontent.com
$api_client_id = "91469454054-nd2tbk1lfhnjti4rbhgljulv0m0orcir.apps.googleusercontent.com";
$api_client_secret = "o_Vfjx6LcIbCJDi3hGbCr3H7";
$api_simple_key = "AIzaSyCp81hY26Dy0nQ79267MSCyythKEv57elY";

$base_url = "https://wildlabglass.appspot.com";



//https://cloud.google.com/console#/project/apps~wildlabglass/sql/instances/wildlabglass
$db_path = '/cloudsql/wildlabglass:wildlabglass'; //https://developers.google.com/appengine/docs/php/cloud-sql/
$db_username = 'root';
//$db_pwd = 'test001'; // damn, for some reason the password is null
$db_pwd = null;
$db_name = 'glass_db'; //database is pre-created at http://23.236.58.219/phpmyadmin/





$contact_id = "wildlab-glass-contact";
$contact_name = "The WildLab Dev";


