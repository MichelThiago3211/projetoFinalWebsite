<?php
	// abre sessão
	session_start();
	session_destroy();
	header("Location: ../login");
?>