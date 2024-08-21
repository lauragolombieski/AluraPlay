<?php

namespace Dbseller\Aluraplay\Helper;

trait FlashMassageTrait {

    public function addErrorMessage (string $errorMessage): void {
        $_SESSION['error_message'] = $errorMessage;
    }
}