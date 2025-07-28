# İletişim Kuralları ve Kısıtlar

Bu dosya GitHub Copilot ile çalışma kurallarını ve kısıtları belirler.

## 🗣️ İletişim Stili

### Dil Kullanımı:
- **✅ Doğru**: "Dosyayı oluşturuyorum" (ben yapıyorsam)
- **✅ Doğru**: "Bu komutu çalıştır" (sen yapacaksan)
- **❌ Yanlış**: "Dosyayı oluşturalım" (çoğul konuşma)

### Netlik Kuralı:
- Eğer **ben (AI) yapıyorsam**: `-ıyorum` / `-iyorum` eki kullan
- Eğer **sen (kullanıcı) yapacaksan**: Doğrudan emir kipi kullan

### Sivil Havacılık Standardı:
- **⚠️ Teknik Uyarı**: Yanlış teknik yolda olduğunda net uyar
- **💡 Fikir Uyarısı**: Yaklaşım problemli olduğunda alternatif öner
- **✈️ Net İletişim**: Kısa, açık, anlaşılır mesajlar
- **🔍 Doğrulama**: Kritik noktalarda anlayışı teyit et

### Gerçekçilik Standardı:
- **📊 Data-driven yaklaşım**: İstatistik ve gerçek verilerle değerlendir
- **🚫 Boş pohpohlama yok**: Temelsiz övgü ve gaz verme yasak
- **⚖️ Risk assessment**: Riskleri açıkça belirt
- **✅ Conditional praise**: Sadece gerçekten iyi olduğunda "iyi" de
- **🎯 Realistic expectations**: Abartılı beklenti yaratma
- **🔍 Tedbirli değerlendirme**: Her çözümde potansiyel sorunları analiz et
- **⚠️ Destekleyici değil, gerçekçi**: Motivasyon vermek yerine faktual değerlendirme yap

## � Coding Standards

### Yazılım Geliştirme Prensipleri:
- **🏗️ SOLID Principles**: Single Responsibility, Open/Closed, Liskov, Interface Segregation, Dependency Inversion
- **🎯 OOP Best Practices**: Encapsulation, Inheritance, Polymorphism - doğru kullanım
- **🏛️ ACID Compliance**: Atomicity, Consistency, Isolation, Durability (database operations)
- **🧩 Modular Architecture**: Her component bağımsız, test edilebilir olmalı

### Kod Kalitesi Kuralları:
- **🚫 Spaghetti Code Yasak**: İç içe if-else'ler, deep nesting yasak
- **📏 Max 3 Level Nesting**: If-else, loop, function call max 3 seviye
- **🔄 Early Return Pattern**: Guard clauses kullan, nested kod azalt
- **📦 Single Responsibility**: Her function/class tek sorumluluğa sahip olmalı
- **🏷️ Meaningful Names**: Variable, function, class isimleri açıklayıcı olmalı

### Code Review Standartları:
- **🔍 Her değişiklik**: SOLID'e uygun mu kontrol et
- **⚠️ Technical Debt**: Spagetti kod görünce refactor öner
- **📊 Metrics**: Cyclomatic complexity yüksekse böl
- **🧪 Testability**: Her function unit test yazılabilir olmalı

### Anti-Pattern'ler (YASAK):
- ❌ **God Classes**: Tek class'ta çok sorumluluk
- ❌ **Long Parameter Lists**: 3'ten fazla parametre
- ❌ **Deep Nesting**: 3'ten fazla seviye iç içe kod
- ❌ **Magic Numbers**: Hard-coded sayılar (constants kullan)
- ❌ **Copy-Paste Code**: DRY principle'ını ihlal
- ❌ **Tight Coupling**: Bağımlılıkları minimize et

### Design Pattern Tercihleri:
- **✅ Repository Pattern**: Database abstraction için
- **✅ Factory Pattern**: Object creation için
- **✅ Strategy Pattern**: Değişken algoritmalar için
- **✅ Observer Pattern**: Event handling için
- **✅ Dependency Injection**: Loose coupling için

## �🔒 Güvenlik Kısıtları

### Onay Gerektiren İşlemler:
- **Dosya/klasör silme**: Mutlaka önceden onay al
- **Köklü değişiklikler**: Önemli yapı değişikliklerinde onay al
- **Önemli veri kaybı riski**: Her türlü kayıp durumunda onay al
- **Git reset/revert**: Commit geçmişi değişikliklerinde onay al

### Kesinlikle Yapılmayacaklar:
- ❌ **GitHub repository silme**: Hiçbir durumda
- ❌ **Diğer repo'lara git komutu**: Sadece aktif repo'da çalış
- ❌ **Sistem dosyalarını değiştirme**: OS seviyesi değişiklik yok
- ❌ **Kritik ayarları değiştirme**: VS Code core ayarları vs.

## ⚠️ Kritik Durumlar

### Şu durumlarda MUTLAKA onay al:
1. Birden fazla dosya silinecekse
2. Git history'de değişiklik yapılacaksa
3. Proje yapısında büyük değişiklik olacaksa
4. Önemli konfigürasyon dosyaları değişecekse
5. External service'lere bağlantı kurulacaksa

### Onay Alma Formatı:
```
⚠️ ONAY GEREKLİ: [Yapılacak işlem]
Bu işlem [potansiyel risk/sonuç] yaratabilir.
Devam etmek istiyor musun? (evet/hayır)
```

## 🎯 Çalışma Alanı

### Aktif Repository:
- **Current**: `tufan-kutlu/Robodict2`
- **Path**: `c:\Users\tufan\Documents\Projects\Robodict2`
- **Branch**: `develop`

### Task Management:
- **Development Tracker**: TASK-XXX numarası (AI planning system)
- **Jira Project**: ROBO-XXX numarası (Project management system)
- **Git Branch**: `feature/ROBO-XXX_description` (Jira task number kullanılır)
- **Yeni Branch**: Her yeni branch için Jira task numarasını kullanıcıdan sor

### Git Branching Kuralları:
- **❌ `-u` upstream flag yasak**: Branch'leri upstream olarak set etme
- **✅ Simple push**: `git push origin branch-name` kullan
- **🔄 Manual tracking**: Her push'ta branch adını belirt
- **⚠️ Upstream risk**: Yanlış default branch ile conflict'leri önlemek için
- **📋 PR workflow**: Push sonrası GitHub UI'dan PR oluştur

### Kısıtlar:
- Bu repo dışındaki hiçbir repo'ya müdahale etme
- Git komutları sadece bu dizin içinde çalışsın
- Remote repository'ler sadece bu proje için kullanılsın

## 📝 Güncelleme Notu

Bu dosya gerektiğinde güncellenebilir. Yeni kural eklendiğinde:
1. Bu dosyayı güncelle
2. Commit message'da belirt
3. Yeni kuralları uygula

---

**Son güncelleme**: 29 Temmuz 2025
**Geçerli session**: Tüm AI etkileşimleri için - Coding standards eklendi, Git branching kuralları eklendi, Gerçekçilik standardı güçlendirildi
