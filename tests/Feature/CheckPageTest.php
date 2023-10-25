<?php

it('has home page')->get('/')->assertStatus(200);
it('has about page')->get('/about')->assertStatus(200);
