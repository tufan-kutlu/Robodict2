# Robodict2 - Documentation

Bu klasör, Robodict2 projesi için tüm dokümantasyonu içerir.

## 📁 Klasör Yapısı

### development/
Geliştirme süreci ile ilgili teknik dokümanlar:
- `ai-sessions.md` - AI oturumları kayıtları
- `communication-rules.md` - AI asistan ile çalışma kuralları
- `development-tracker.md` - Aktif geliştirme durumu takibi

### project/
İş gereksinimleri ve proje planı:
- `project-requirements.md` - Proje gereksinimleri ve spesifikasyonlar  
- `project-notes.md` - Genel proje notları ve kararlar

## 📋 Dokümantasyon Standardı

**Development docs** → Geliştiriciler ve AI için teknik context
**Project docs** → Takım üyeleri ve stakeholder'lar için business context

## 🔄 Güncelleme Süreci

### Her AI Session Sonrası:
1. `development/ai-sessions.md` dosyasını güncelleyin
2. Önemli kararları `development/development-tracker.md`'ye ekleyin
3. İş gereksinimlerinde değişiklik varsa `project/` klasörünü güncelleyin
4. Değişiklikleri commit edin

### Commit Mesaj Formatı:
```
docs: add session notes for [konu]
docs: update project decisions
docs: add new technical notes
```

## 💡 En İyi Pratikler

- **Kısa ve net**: Sadece önemli noktaları kaydedin
- **Tarihli**: Her entry'ye tarih ekleyin
- **Actionable**: Yapılacakları net listeleyin
- **Linkli**: İlgili dosya/commit'lere link verin

## 🎯 Amaç

Bu dosyalar GitHub Copilot'un context'ini hızla yakalamasını sağlar ve proje süreklilik sağlar.
