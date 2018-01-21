<?php

/**
 * @file    ApiController.php
 * @brief   Controller to handle api requests.
 * @date    30.06.2017
 * @author  Raphael Lekies
 */


/**
 * @class  ApiController
 */

class ApiController extends Controller {

    function get_downloader_jobs() {
        $api = new DownloaderJob($this->db);
        $api->getJob();

        $this->f3->set('view', 'api/default.html');
        echo json_encode($api->cast());
    }

    function get_downloader_jobs_wss() {
      $api = new DownloaderJob($this->db);
      $test = $api->getJobsByExchange($this->f3->get('PARAMS.exchange'));

      $cast=array();
      foreach ($test as $x)
        $cast[] = $x->cast();

      $namedArray = array();
      $namedArray['jobs_wss'] = $cast;

      $this->f3->set('view', 'api/default.html');
      echo json_encode($namedArray);
    }

    function get_importer_jobs() {
      $api = new ImporterJob($this->db);
      $api->getJob();

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function set_downloader_jobs_state() {
        $api = new DownloaderJob($this->db);

        // parse json data
        $obj = json_decode($this->f3->get('BODY'));

        foreach($obj as $row) {
            $result = $api->setJobState($this->f3->get('PARAMS.id'), $row->action);
            if ($result == 1) {
              $api->downloader_jq_id = $this->f3->get('PARAMS.id');
              $api->action = $row->action;
            }

        }

        $this->f3->set('view', 'api/default.html');
        echo json_encode($api->cast());
    }

    function add_tickdata() {
      $api = new BondsCurrent($this->db);

      // parse json data
      $obj = json_decode($this->f3->get('BODY'));

      foreach($obj as $row) {
          $result = $api->add($row->isin, $row->exchange, $row->high, $row->low, $row->bid, $row->ask, $row->volume, $row->datetime, $row->last);

      }

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());

    }

    function set_importer_jobs_state() {
        $api = new ImporterJob($this->db);

        // parse json data
        $obj = json_decode($this->f3->get('BODY'));

        foreach($obj as $row) {
            $result = $api->setJobState($row->current_action, $row->new_action, $row->filename);
            if ($result == 1) {
              $api->action = $row->action;
            }

        }

        $this->f3->set('view', 'api/default.html');
        echo json_encode($api->cast());
    }

    function insert_import_jq() {
      $api = new ImporterJob($this->db);

      // parse json data
      $obj = json_decode($this->f3->get('BODY'));

      foreach($obj as $row) {
        echo "Add the following: action: ". $row->action ." id_stock ". $row->id_stock ." filename ". $row->filename;
        $result = $api->add($row->action, $row->id_stock, $row->filename);
        if ($result == 1) {
          $api->action = $row->action;
          $api->id_stock = $row->id_stock;
        } else {
          $api->action = 0;
        }
      }

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_currency() {
      $api = new Currency($this->db);
      $api->getCurrencyBySymbol($this->f3->get('PARAMS.symbol'));

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_exchange() {
      $api = new Exchange($this->db);
      $api->getExchangeBySymbol($this->f3->get('PARAMS.symbol'));

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_mailer_jobs() {
      $api = new MailerJob($this->db);
      $api->getJob();

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function set_mailer_jobs_state() {
      $api = new MailerJob($this->db);

      // parse json data
      $obj = json_decode($this->f3->get('BODY'));

      foreach($obj as $row) {
          $result = $api->setJobState($this->f3->get('PARAMS.id'), $row->action);
          if ($result == 1) {
            $api->action = $row->action;
            $api->idemail_queue = $this->f3->get('PARAMS.id');
          }

      }

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_advicer_jobs() {
      $api = new AdvicerJob($this->db);
      $api->getJob();

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_indicator_jobs() {
      $api = new IndicatorJob($this->db);
      $api->getJob();

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function set_indicator_job_state() {
      $api = new IndicatorJob($this->db);

      // parse json data
      $obj = json_decode($this->f3->get('BODY'));

      foreach($obj as $row) {
          $result = $api->setJobState($this->f3->get('PARAMS.id'), $row->action);
          if ($result == 1) {
            $api->action = $row->action;
            $api->idemail_queue = $this->f3->get('PARAMS.id');
          }
      }

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_tradingpair() {
      $api = new ExchangeToTrade($this->db);
      $test = $api->getTradingpairByExchange($this->f3->get('PARAMS.exchange_id'));

      $cast=[];
      foreach ($test as $x)
        $cast[]=$x->cast();

      $this->f3->set('view', 'api/default.html');
      echo json_encode($cast);
    }

    function get_tradingpair_base() {
      $api = new ExchangeToTrade($this->db);
      $api->getTradingpairByExchangeAndBase($this->f3->get('PARAMS.exchange_id'), $this->f3->get('PARAMS.base'));

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
    }

    function get_tradingpair_unitprice() {
      $currency = new Currency($this->db);
      $currency_now = new CurrencyNow($this->db);
      $redis = new CurrencyNowRedis($this->redis);
      echo $redis->addJobToQueue(uniqid(), 'btc');

      $base = $currency->getCurrencyBySymbol($this->f3->get('PARAMS.base'));
      $quote = $currency->getCurrencyBySymbol($this->f3->get('PARAMS.quote'));

      $currency_now->getUnitpriceByBaseQuoteExchange($base[0]['currency_id'], $quote[0]['currency_id'], $this->f3->get('PARAMS.exchange_id'));

      $this->f3->set('view', 'api/default.html');
      echo json_encode($currency_now->cast());
    }

    function get_stock_prices_1min() {
      $currency = new BondsCurrentOneMinute($this->db);

      $test = $currency->getPriceById($this->f3->get('PARAMS.bond_id'), $this->f3->get('PARAMS.period'));


      $cast=array();
      foreach ($test as $x)
        $cast[] = $x->cast();

      $namedArray = array();
      $namedArray['prices'] = $cast;

      $this->f3->set('view', 'api/default.html');
      echo json_encode($namedArray);
    }

    function add_trenddata() {
      $trend = new Trend($this->db);

      // parse json data
      $obj = json_decode($this->f3->get('BODY'));

      foreach($obj as $row) {
          //echo "Bond: ".$row->bond_id."; Indicator: ".$row->indicator."; Value: ".$row->indicator_value."; ";
          $result = $trend->add($row->bond_id, $row->currency_flag, $row->stock_flag, $row->indicator, $row->indicator_value);
      }


      $this->f3->set('view', 'api/default.html');
      echo json_encode($trend->cast());
    }

    // Later on we need to validate all json input.
    function json_validate($string) {
      // decode the JSON data
      $result = json_decode($string);

      // switch and check possible JSON errors
      switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid // No error has occurred
            break;
        case JSON_ERROR_DEPTH:
            $error = 'The maximum stack depth has been exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Invalid or malformed JSON.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Control character error, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        // PHP >= 5.3.3
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_RECURSION:
            $error = 'One or more recursive references in the value to be encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_INF_OR_NAN:
            $error = 'One or more NAN or INF values in the value to be encoded.';
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            $error = 'A value of a type that cannot be encoded was given.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
      }

      if ($error !== '') {
        // throw the Exception or exit // or whatever :)
        exit($error);
      }

      // everything is OK
      return $result;
    }
}
