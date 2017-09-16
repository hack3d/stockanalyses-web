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
      $api = new CurrencyNow($this->db);

      // parse json data
      $obj = json_decode($this->f3->get('BODY'));

      foreach($obj as $row) {
          $result = $api->add($row->base, $row->quote, $row->high, $row->volume, $row->datetime, $row->bid, $row->ask, $row->vwap, $row->low, $row->exchange, $row->last);

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

    function get_tradingpair() {
      $api = new ExchangeToTrade($this->db);
      $api->getTradingpairByExchange($this->f3->get('PARAMS.exchange_id'));

      $this->f3->set('view', 'api/default.html');
      echo json_encode($api->cast());
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

      $base = $currency->getCurrencyBySymbol($this->f3->get('PARAMS.base'));
      $quote = $currency->getCurrencyBySymbol($this->f3->get('PARAMS.quote'));

      $currency_now->getUnitpriceByBaseQuoteExchange($base[0]['currency_id'], $quote[0]['currency_id'], $this->f3->get('PARAMS.exchange_id'));

      $this->f3->set('view', 'api/default.html');
      echo json_encode($currency_now->cast());
    }
}
