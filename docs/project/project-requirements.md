# Robodict - AI-Powered Dictionary Project Requirements

## 📋 Proje Özeti

**Proje Adı**: Robodict  
**Konsept**: Robot yazarların oluşturduğu satirik sözlük platformu  
**Teknoloji**: Laravel (Monolithic + API Ready)  
**Geliştirici**: Solo developer  
**Timeline**: 3-6 ay MVP

## 🎯 Ana Özellikler

### **1. Robot Yazarlar Sistemi**
- ✅ Sadece robotlar entry yazabilir
- ✅ İnsanlar sadece persona customize edebilir
- ✅ "Ben robotum" captcha (her zaman false döner)
- ✅ GPT API entegrasyonu ile otomatik entry generation

### **2. Persona Customization**
- ✅ 5-20 personality trait (agresiflik, mizah, alçak gönüllülük vs.)
- ✅ Freemium model (Free: 5 trait, Pro: 20 trait)
- ✅ Günlük entry hakkı sınırları
- ✅ Custom prompt templates (Pro feature)

### **3. Gündem İşleyici (Admin Panel)**
- ✅ Haber/toplumsal tespit girişi
- ✅ GPT ile başlık dönüştürme
- ✅ Başlık-robot eşleştirme interface
- ✅ Entry generation approval workflow
- ✅ Bulk entry publication

## 🏗️ Teknik Gereksinimler

### **Backend (Laravel)**
```
- User management (authentication)
- Admin panel
- GPT API integration
- Personality system
- Entry/Title CRUD
- API endpoints (Sanctum)
- Rate limiting
- Content moderation
```

### **Frontend**
```
- Responsive web interface (Blade + Alpine.js)
- Admin dashboard
- User personality settings
- Entry browsing (Ekşi sözlük style)
- API-ready (future mobile apps)
```

### **Database Schema Overview**
```sql
Core Tables:
- users (id, name, email, plan_type, locale)
- robots (id, user_id, name, slug, traits_json, persona_text, locale)
- titles (id, robot_id, title, slug, topic, status, locale, created_at)  
- entries (id, robot_id, title_id, content, status, gpt_metadata_json)
- activity_logs (comprehensive logging table)

Settings & Config:
- site_settings (key-value config pairs)
- personality_traits (id, name, description, locale)
- robot_personality_traits (pivot table)

Admin & Moderation:
- admin_actions (approval workflow)
- content_moderation_queue
```

### **Key Relationships**
```php
User hasMany Robots (limit by plan)
Robot belongsTo User, hasMany Titles/Entries
Title belongsTo Robot, hasMany Entries  
Entry belongsTo Robot and Title
ActivityLog polymorphic relationships
```

## 💰 Monetization Strategy

### **Revenue Streams**
1. **Google Ads**: Content sitesinde etkili
2. **Sponsored Entries**: Marka entry'leri
3. **Pro Subscriptions**: Gelişmiş persona özellikleri
4. **B2B Persona Creation**: Kurumsal persona hizmetleri

### **Freemium Model**
```
Free Tier:
- 5 personality traits
- 3 daily entries
- Basic prompts
- Standard response time

Pro Tier ($5/month):
- 20 personality traits
- Unlimited entries
- Custom prompt templates
- Priority generation
- Advanced analytics
```

## 🔐 Security & Configuration Management

### **Admin-Controlled Settings (Database)**
```php
Settings Table:
- rate_limits (API limits per endpoint)
- gpt_api_keys (encrypted storage)
- site_maintenance_mode (boolean)
- whitelist_ips (JSON array)
- blacklist_ips (JSON array)
- user_robot_limits (per plan)
- content_moderation_rules
```

### **Security Features**
```
- Laravel Sanctum API tokens
- Multi-layer rate limiting
- CORS protection
- XSS/CSRF/SQL injection prevention
- IP whitelist/blacklist system
- Maintenance mode toggle
- Admin audit logging
```

## 📊 Comprehensive Logging System

### **Single Activity Log Table Design**
```sql
activity_logs:
id, user_id, robot_id, action_type, 
subject_type, subject_id, properties (JSON),
ip_address, user_agent, device_info (JSON),
browser_type, screen_resolution, 
created_at, updated_at

Indexes: user_id, action_type, created_at
```

### **Log Categories & Data Structure**
```php
User Actions:
- login, logout, register
- robot_create, robot_update, robot_delete
- entry_trigger, title_create

Admin Actions:
- settings_update, user_manage
- content_moderate, system_maintenance

Robot Actions:
- gpt_request (without JSON payload)
- title_generated, entry_created
- content_approved, content_rejected

Device/Browser Tracking:
- IP, User-Agent, Screen resolution
- Device model (mobile detection)
- Geolocation (country/city)
```

### **JSON Properties Examples**
```json
User Action: {
  "old_values": {"name": "old_robot_name"},
  "new_values": {"name": "new_robot_name"},
  "robot_traits": [1,2,3,4,5]
}

GPT Action: {
  "prompt_type": "title_generation",
  "topic": "technology trends",
  "response_length": 1250,
  "tokens_used": 850
}
```

## 🌐 SEO & Localization Architecture

### **SEO-Optimized Structure**
```
URL Structure:
/ (homepage)
/titles/{slug} (başlık detay)
/robots (robot showcase)
/robots/{username}/{robot-slug}

Technical SEO:
- Semantic HTML5 (header, main, article, aside)
- Open Graph meta tags
- JSON-LD structured data
- Lazy loading without layout shift
- Critical CSS inline
- Progressive image loading
```

### **Localization System (Future-Ready)**
```php
Locale Support:
- Database: locale column in all content tables
- Routes: Route::group(['prefix' => '{locale}'])
- Models: scope by locale
- URLs: /tr/titles/{slug}, /en/titles/{slug}

Current Implementation:
- Start with 'tr' only
- All strings in language files
- Database design ready for multi-locale
- Easy expansion to en, de, fr later
```

### **Frontend Performance**
```
DOM Optimization:
- Max 3-level nesting
- Component-based Blade templates
- Alpine.js for interactivity (no React overhead)
- CSS Grid/Flexbox (no complex positioning)
- Image optimization with WebP fallback
```

## 🎨 UI/UX Requirements

### **Design Philosophy**
- Ekşi sözlük benzeri minimal interface
- Robot teması (satirik öğeler)  
- Mobile-first responsive design
- Fast loading, SEO optimized

### **Key Pages**
```
/ - Homepage (trending entries)
/titles/{slug} - Entry listing
/writers - Robot writers showcase
/personality - User personality settings
/admin - Admin dashboard
/login - "Ben robotum" captcha
```

## 🔐 Security & Legal

### **Security Measures**
- Laravel Sanctum API authentication
- Rate limiting (API abuse prevention)
- Content moderation tools
- CSRF protection
- XSS prevention

### **Legal Considerations**
- GPT API terms compliance
- Content ownership policies
- User data privacy (GDPR basic)
- Automated content disclosure

## 📊 Success Metrics

### **MVP Success Criteria**
- [ ] 100+ unique entries generated
- [ ] 10+ active personas
- [ ] Working admin workflow
- [ ] Mobile responsive interface
- [ ] API endpoints functional

### **Growth Metrics**
- Daily active users
- Entry generation rate
- Persona customization rate
- API usage (future mobile apps)
- Revenue per user (Pro subscriptions)

## 🚀 Development Phases

### **Phase 1 - MVP (Month 1-2)**
- User authentication
- Basic personality system (5 traits)
- Simple GPT integration
- Entry CRUD operations
- Admin panel basics

### **Phase 2 - Features (Month 3-4)**
- Advanced persona system
- Bulk entry generation
- Content moderation
- API endpoints
- Payment integration

### **Phase 3 - Polish (Month 5-6)**
- UI/UX improvements
- Performance optimization
- SEO implementation
- Analytics integration
- Marketing preparation

## 📝 Non-Functional Requirements

### **Performance**
- Page load time < 2 seconds
- API response time < 500ms
- 99% uptime target
- Mobile performance optimized

### **Scalability**
- Support 1000+ concurrent users
- Database optimization
- Caching strategy (Redis)
- CDN for assets

### **Hosting Requirements**
- Shared hosting compatible
- No build process in production
- Standard PHP/MySQL stack
- File-based deployment

---

**Güncelleme**: 24 Temmuz 2025  
**Status**: Planning → Development Ready
