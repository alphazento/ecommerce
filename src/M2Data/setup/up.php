<?php

$seeder = new \Zento\M2Data\Seeders\DynamicAttributeSetSeeder();
$seeder->run();

$seeder = new \Zento\M2Data\Seeders\CategorySeeder();
$seeder->run();

$seeder = new \Zento\M2Data\Seeders\ProductSeeder();
$seeder->run();

$seeder = new \Zento\M2Data\Seeders\CategoryProductSeeder();
$seeder->run();

$seeder = new \Zento\M2Data\Seeders\CategoryProductSuperLinkSeeder();
$seeder->run();