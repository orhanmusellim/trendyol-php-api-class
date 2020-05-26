<?php
include "vendor/autoload.php";
use GuzzleHttp\Client;
class Trendyol {
    function __construct() {
        $CI = get_instance();
        $this->supplierId = 'Your Trendyol Supplier ID';
        $this->username = 'Your Trendyol Username';
        $this->password = 'Your Trendyol Password';
        $options['headers'] = array(
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password),
            'Content-Type' => 'application/json'
        );
        $options['http_errors'] = false;
        $this->guzzle = new GuzzleHttp\Client($options);
        $this->baseurl = 'https://api.trendyol.com/sapigw/suppliers/';
        $this->categories = null;
    }
    /*
     *
     *
     * TRENDYOL ÜRÜN ENTEGRASYONLARI
     *
     *
     * */
    /*
     * Trendyol Markalarını Getirir
    */
    public function getBrands($page = null, $size = null) {
        $url = 'https://api.trendyol.com/sapigw/brands?';
        if ($page != null) {
            $url .= 'page=' . $page;
        }
        if ($size != null) {
            $url .= 'size=' . $size;
        }
        $response = $this->guzzle->get($url);
        return $response;
    }
    /*
     * Trendyol Markasını ismine göre filtreleyerek getirir.
    */
    public function getBrandsWithName($name) {
        $response = $this->guzzle->get('https://api.trendyol.com/sapigw//brands/by-name?name=' . $name);
        return $response;
    }
    /*
     * Trendyol Kategorilerini Getirir.
    */
    public function getCategories() {
        $returnData = $this->guzzle->get('https://api.trendyol.com/sapigw/product-categories?ParentId=' . 403);
        return $returnData;
    }
    /*
     * Trendyol Kategorilerine ait özellik listesini döndürür.
    */
    public function getCategorieAttributes($categoryId) {
        $response = $this->guzzle->get('https://api.trendyol.com/sapigw/product-categories/' . $categoryId . '/attributes');
        return $response;
    }
    /*
     * Trendyol'un çalıştığı tüm kargo firmalarını döner
    */
    public function getShipmentProviders() {
        //Kargo Firmalarını Listeler
        $response = $this->guzzle->get('https://api.trendyol.com/sapigw/shipment-providers');
        return $response;
    }
    /*
     * Trendyol Kullanıcı hesabınızda kayıtlı olan Adreslerini döndürür.
    */
    public function getSuppliersAdress() {
        $url = $this->baseurl . $this->supplierId . '/addresses';
        $response = $this->guzzle->get($url);
        return $response;
    }
    /*
     * Trendyol üzerindeki ürünlerinizi fitrelemeye yarar. Verilen değerlere göre ürünleri döndürür.
    */
    public function getProducts($approved = true, $page = null, $size = null, $barcode = null, $startDate = null, $endDate = null) {
        $url = $this->baseurl . $this->supplierId . '/products?';
        if ($approved != null) {
            $url .= 'approved=' . $approved;
        }
        if ($barcode != null) {
            $url .= '&barcode=' . $barcode;
        }
        if ($page != null) {
            $url .= '&page=' . $page;
        }
        if ($size != null) {
            $url .= '&size=' . $size;
        }
        if ($startDate != null) {
            $url .= '&startDate=' . $startDate;
        }
        if ($endDate != null) {
            $url .= '&endDate=' . $endDate;
        }
        $response = $this->guzzle->get($url);
        return $response;
    }
    /*
     * Trendyol üzerindeki ürününüzü barkod numarası ile sorgular ve döndürür.
    */
    public function getProductsWithBarcode($barcode = null) {
        $url = $this->baseurl . $this->supplierId . '/products?';
        if ($barcode != null) {
            $url .= '&barcode=' . $barcode;
        }
        $response = $this->guzzle->get($url);
        return $response;
    }
    /*
     * Trendyol üzerine aktardığınız üründen dönen batchRequestId ile aktarım durumunu sorguluyabilirsiniz.
    */
    public function getProductsWithBatchRequest($batchRequest) {
        $url = $this->baseurl . $this->supplierId . '/products/batch-requests/' . $batchRequest;
        $response = $this->guzzle->get($url);
        return $response;
    }
    /*
     * Trendyol üzerine ürün aktarımı yapmayı sağlar. Ürün formatı trendyola uygun olmalıdır.
    */
    public function updateProduct($item, $type) {
        $url = $this->baseurl . $this->supplierId . '/v2/products';
        $items[] = $item;
        $data['items'] = $items;
        $options['body'] = json_encode($data);
        $options['headers'] = array(
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password),
            'Content-Type' => 'application/json'
        );
        $options['http_errors'] = false;
        $guzzle = new GuzzleHttp\Client($options);
        if ($type == "create") {
            $response = $guzzle->post($url);
        }
        elseif ($type == "update") {
            $response = $guzzle->put($url);
        }
        return $response;
    }
    /*
     * Trendyol üzerinde mevcut ürününüzün sadece stok ve fiyat bilgisini güncellemenize yarar.
    */
    public function updateProductPriceAndInventory($item) {
        $url = $this->baseurl . $this->supplierId . '/products/price-and-inventory';
        $items[] = $item;
        $data['items'] = $items;
        $options['body'] = json_encode($data);
        $options['headers'] = array(
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password),
            'Content-Type' => 'application/json'
        );
        $options['http_errors'] = false;
        $guzzle = new GuzzleHttp\Client($options);
        $response = $guzzle->post($url);
        return $response;
    }
    /*
   *
   *
   * TRENDYOL SİPARİŞ ENTEGRASYONLARI
   *
   *
   * */
    /*
     * Trendyol Siparişlerini Durumlarını Döner
     */
    public function getOrderStatusWithKey($key = null) {
        $status = array(
            "Awaiting" => array("title" => "Beklemede", "class" => "text-warning fa-clock-o"),
            "Created" => array("title" => "Oluşturuldu", "class" => "text-success fa-plus-circle"),
            "Picking" => array("title" => "Paket Oluşturuluyor", "class" => "text-success fa-cube"),
            "Invoiced" => array("title" => "Fatura Hazırlanıyor", "class" => "text-success fa-file-pdf-o"),
            "Shipped" => array("title" => "Kargoda", "class" => "text-success fa-truck"),
            "Cancelled" => array("title" => "İptal Edildi", "class" => "text-danger fa-minus-circle"),
            "Delivered" => array("title" => "Teslim Edildi", "class" => "text-success fa-check-circle"),
            "UnDelivered" => array("title" => "Teslim Edilemedi", "class" => "text-danger fa-minus-circle"),
            "Returned" => array("title" => "İade Edildi", "class" => "text-info fa-minus-circle"),
            "Repack" => array("title" => "Yeniden Paketleniyor", "class" => "text-info fa-cube"),
            "UnSupplied" => array("title" => "Tedarik Edilemedi", "class" => "text-danger fa-times"),
            "ReadyToShip" => array("title" => "Kargolamaya Hazır", "class" => "text-primary fa-refresh"),
        );
        if ($key != null) {
            if (isset($status[$key])) {
                return $status[$key];
            }
            else {
                return array("title" => $key, "class" => "text-info fa-question-circle-o");
            }
        }
        else {
            return $status;
        }
    }
    /*
     * Trendyol Siparişlerini Getirir
     */
    public function getOrders($status = "Created,Invoiced,Picking,Shipped,Delivered,Returned,UnDelivered", $size = 200, $startDate = null, $endDate = null, $orderByField = "PackageLastModifiedDate", $orderByDirection = "DESC") {
        $url = $this->baseurl . $this->supplierId . '/orders';
        $url .= '?status=' . $status;
        if ($size != null) {
            $url .= '&size=' . $size;
        }
        if ($startDate != null) {
            $url .= '&startDate=' . strtotime($startDate);
        }
        if ($endDate != null) {
            $url .= '&endDate=' . strtotime($endDate);
        }
        if ($orderByField != null) {
            $url .= '&orderByField=' . $orderByField;
        }
        if ($orderByDirection != null) {
            $url .= '&orderByDirection=' . $orderByDirection;
        }
        $response = $this->guzzle->get($url);
        return $response;
    }
}