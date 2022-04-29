<?php
function redirect(string $redirectPath): void
{
    header("location: " . $redirectPath);
    exit();
}
