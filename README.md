<!-- PROJECT LOGO -->
<br />
<p align="center">

  <div align="center">
  <img src="assets/om-logo.png" alt="Logo" width="180" height="180">
  </div>

  <h2 align="center">PHP - Trendyol API Class</h2>
     <br />
<div align="center">
  <img src="assets/trendyol-logo.png" alt="Logo" width="180">
  </div>
  <br />
  <p align="center">
    PHP Projelerinize dahil ederek kullanabileceğiniz Trendyol API Entegrasyonu için hazırlanmış basit bir Class'dır.
    <br />
    
  </p>

</p>


## Kurulum

1. Repoyu Klonlayın

2. trendyol.php içerisindeki `supplierId`, `username`, `password` alanlarını Trendyol üzerindeki bilgileriniz ile güncellemeyi unutmayın !

3. Composer üzerindeki bağımlılıkları kurun.

```sh
composer install
```

4. Kullanmaya başlayın.

## Kullanım

1. Sınıfı sayfanıza dahil edin.

2. Trendyol Kategorilerini listelemek için aşağıdaki gibi kullanabilirsiniz. Methodlar içerisinde parametre değerlerine göre sınıf kullanımını özelleştirebilirsiniz.

```sh
$this->trendyol->getCategories();
```

## Not

1. Guzzle kullanmak istemezseniz aynı mantıkta CURL de kullanabilirsiniz. Guzzle tamamen tercihen seçilmiştir.
