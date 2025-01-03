<?php

namespace Izopi4a\SpeedyBundle\Service;
use GuzzleHttp\Client;
class SpeedyService
{

    CONST string API_URL = "https://api.speedy.bg/v1/";

    private string $user;
    private string $password;
    private string $locale;
    private Client $client;
    /**
     * @var array|mixed
     */
    private mixed $data;

    public function __construct(string $user, string $password, string $locale)
    {
        $this->user = $user;
        $this->password = $password;
        $this->locale = $locale;
    }

    public function doSomething(): string
    {
        return 'Service is working!';
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }
    
    //
    protected function addDefaultData()
    {
        $this->addData("userName", $this->user);
        $this->addData("password", $this->password);
        $this->addData("language", $this->locale);
    }

    public function setData(array $data): self
    {

        $this->data = $data;

        return $this;
    }

    public function getData(): array
    {

        return $this->data;
    }

    public function addData(string $name, $value): self
    {

        $data = $this->getData();

        if (isset($data[$name])) {
            throw new \Shop\Speedy\Exception("key already exists in data, use update data !");
        }

        $this->data[$name] = $value;

        return $this;
    }

    public function updateData(string $name, string $value): self
    {

        $data = $this->getData();

        if (false === isset($data[$name])) {
            throw new \Shop\Speedy\Exception("key does NOT exists in data, use addData method");
        }

        $this->data[$name] = $value;

        return $this;
    }

    protected function getClient() : Client
    {

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => self::API_URL,
            // You can set any number of default request options.
            'timeout'  => 10.0,
            'verify' => false,
            'debug' => false
        ]);
        
        return $client;
    }

    public function make( string $subPath)
    {

        $options = [];

        if (count($this->getData()) > 0) {
            $options['json'] = $this->getData();
        }

        $client = $this->getClient();

        $request = $client->request('POST', $subPath, $options);

        if ($request->getStatusCode() !== 200) {
            throw new \Shop\Speedy\Exception("bad status code form speedy");
        }

        $body = (string)$request->getBody();

        return  json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }

    private function resetData()
    {
        $this->data = [];
        $this->addDefaultData();
    }

    public function findCity(string $name, int $countryId = 100/*BG*/, bool $exact = false): array
    {

        $this->resetData();
        $this->addData("name", $name);
        $this->addData("countryId", $countryId);

        $r = $this->make('location/site');

        $arr = [];
        if (is_array($r->sites) && count($r->sites) > 0) {
            foreach ($r->sites as $site) {
                $arr[] = new Http\Response\Site($site);
            }
        }

        return $arr;
    }

    /**
     *
     * @param Http\Payload\Recipient           $recipient
     * @param Http\Payload\Content             $content
     *
     * @param Http\Payload\CourierServicePayer $courierServicePayer
     *
     * @param float                       $cashOnDelivery
     *
     * @return Http\Response\Delivery
     *
     * @throws Http\Exception
     */
    public function calculateDelivery(
        Http\Payload\Recipient $recipient,
        Http\Payload\Content $content,
        Http\Payload\CourierServicePayer $courierServicePayer,
        float $cashOnDelivery = 0
    ): Http\Response\Delivery {

        $service = [
            'serviceIds'           => [505],
            'autoAdjustPickupDate' => true,
        ];

        if ($cashOnDelivery > 0) {
            $service['additionalServices'] = [
                'cod' => (new Http\Payload\CashOnDelivery($cashOnDelivery))->getData(),
            ];
        }

        $this->resetData();

        $this->addData("recipient", $recipient->getData());
        $this->addData("service", $service);

        $this->addData("content", $content->getData());
        $this->addData("payment", $courierServicePayer->getData());

        $r = $this->make('calculate/');

        $res = new Http\Response\Delivery($r);

        if ($res->hasError()) {
            throw new Http\Exception($res->getError());
        }

        return $res;
    }


    /**
     * @param int   $siteOrOfficeId
     * @param bool  $isOffice
     * @param int   $itemsCount
     * @param float $itemsWeight
     *
     * @param float $cashOnDelivery
     *
     * @return Http\Response\Delivery
     * @throws Exception
     */
    public function quickDeliveryCalc(
        int $siteOrOfficeId,
        bool $isOffice,
        int $itemsCount,
        float $itemsWeight,
        float $cashOnDelivery = 0.00
    ): Http\Response\Delivery {

        if ($isOffice) {
            $recipient = new Http\Payload\Recipient(0, $siteOrOfficeId);
        } else {
            $recipient = new Http\Payload\Recipient($siteOrOfficeId);
        }

        $content = new Http\Payload\Content($itemsCount, $itemsWeight);
        $courierServicePayer = new Http\Payload\CourierServicePayer();

        return $this->calculateDelivery($recipient, $content, $courierServicePayer, $cashOnDelivery);
    }


    /**
     * search for office
     * every param can be passed alone and empty to return all
     *
     * @param int    $siteId
     * @param int    $countryId
     * @param string $name
     *
     * @return Http\Response\Office[];
     * @throws Exception
     *
     */
    public function findOffice(int $siteId = 0, int $countryId = 100, string $name = ""): array
    {

        $this->resetData();

        if ($siteId !== 0) {
            $this->addData("siteId", $siteId);
        }

        $this->addData("countryId", $countryId);

        if ($name !== "") {
            $this->addData("name", $name);
        }


        $r = $this->make('location/office');

        $arr = [];
        if (is_array($r['offices']) && count($r['offices']) > 0) {
            foreach ($r['offices'] as $office) {
                $arr[] = new Http\Response\Office($office);
            }
        }

        return $arr;
    }


}