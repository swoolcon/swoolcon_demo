<?php
/**
 * @brief
 * Created by PhpStorm.
 * User: zy&cs
 * Date: 17-4-27
 * Time: 上午11:01
 */
namespace App\CliModules\Demo;
use Phalcon\Cli\Task;

abstract class Tasks extends Task
{
    public function initialize()
    {

        echo <<<swoolcon
--------------------------------------------------------------------------------------------------

   @@@@@@@  @@@           @@@   @@@@@        @@@@@     @@@        @@@@@@      @@@@@     @@@    @@@
  @@@  @@@@  @@@   @@@   @@@   @@@  @@@     @@@  @@@   @@@       @@@  @@@    @@@  @@@   @@@@   @@@
 @@@    @@@  @@@   @@@   @@@  @@@    @@@   @@@    @@@  @@@      @@@    @@@  @@@    @@@  @@@@   @@@
 @@@         @@@  @@@@@  @@@ @@@      @@@ @@@      @@@ @@@     @@@     @@@ @@@      @@@ @@@@@  @@@
  @@@         @@@ @@@@@  @@@ @@@      @@@ @@@      @@@ @@@     @@@         @@@      @@@ @@@@@  @@@
   @@@@@@     @@@ @@ @@ @@@  @@@      @@@ @@@      @@@ @@@     @@@         @@@      @@@ @@@@@@ @@@
      @@@@@   @@@ @@ @@ @@@  @@@      @@@ @@@      @@@ @@@     @@@         @@@      @@@ @@@ @@@@@@
        @@@   @@@@@@ @@@@@@  @@@      @@@ @@@      @@@ @@@     @@@         @@@      @@@ @@@ @@@@@@
         @@@   @@@@@  @@@@   @@@      @@@ @@@      @@@ @@@     @@@     @@@ @@@      @@@ @@@  @@@@@
 @@@    @@@    @@@@   @@@@    @@@    @@@@  @@@    @@@@ @@@      @@@    @@@  @@@    @@@@ @@@  @@@@@
  @@@   @@@    @@@@   @@@@     @@@  @@@@    @@@  @@@@  @@@       @@@  @@@@   @@@  @@@@  @@@   @@@@
   @@@@@@@     @@@@   @@@@      @@@@@@       @@@@@@    @@@@@@@@   @@@@@@      @@@@@@    @@@    @@@

--------------------------------------------------------------------------------------------------


swoolcon;

    }
}