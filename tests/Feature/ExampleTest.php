<?php

namespace Tests\Feature;

it('has home page')->get('/')->assertStatus(200);

