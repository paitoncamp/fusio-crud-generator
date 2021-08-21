<?php

namespace Wirams\FusioCrudGen;

/**
 * @Author - wira m.s
 * @Email - wira.msukoco@gmail.com
 * @Description - Interface for Database Operations
 */

interface DatabaseRepositoryInterface {
	/* Function to get all the databases from the schema */
	public function getDatabases();

	/* Get all the tables related to specific database */
	public function getTables($database);
}
 
