# Artists4Artists Project

## Status  
![Artist4Artist](https://github.com/ccs-open-source/support-artists-project/workflows/Artist4Artist/badge.svg)

## How it works  

## Install

First you need to clone the project,  
```
git clone git@github.com:ccs-open-source/support-artists-project.git
```

Then install dependencies,
```
composer install && npm install && npm run dev
```  

Make a copy of ``.env.example`` to ``.env`` and then configure at your way, after that
you can create a database and populate database with dummy information.  

```
php artisan key:generate  
php artinsa migrate
php artisan db:seed
```

## TO DO  


### Refactor / Bug Fixes
 - [x] Refactoring Views, there are duplicate views on profile and registration form.  
 - [x] After logged in, must show a welcome message.  
 - [ ] Adding Javascript, when the user want donation, must show/hide the IBAN field.  
 - [x] Register/Login Social Provider, must be able to redirect to homepage or to profile page.  
 - [x] Remover FacebookId from artists table and put on a common place for another social network.    
 - [x] Change url of profile index, change from `/profile` to `/profile/general`, in order to detect where we are on side menu.    
 - [x] Allow user to visit their profile page from top nav bar, clicking on their name.  
 - [x] Only authenticated user can visit pages under `/profile/*`  
 
   
### Stream  
- [ ] Facebook Stream  
- [ ] Youtube Stream  

### Artist  
- [ ] Show Artist Page - Detail about the artist  
- [ ] Show total donation won  
- [ ] Show all stream done in the past  
- [ ] Show social network on page  

### Profile  
- [ ] Adding Twitter and Youtube to Social Login Provider (see documentation for more info).   
- [ ] Adding integration to Patreon or other kind of donation platform  
- [ ] Management of Stream  
- [ ] Permitir fazer logout
- [ ] Permitir fazer download de todos os dados do utilizador logado. (GDPR)
- [ ] Permitir ao utilizador apagar a sua conta e todos os dados associados a ele. (GDRP)
- [ ] Receber notificações ou desactivar notificações. (GDRP)
- [ ] Desassociar Social Providers from Profile

### Integration

- [ ] Integrate Patreon

## Want contribute

Make sure create all necessary unit test and must passed, after that you pull request it will 
be reviewed. In order to make ease to evaluated your PR write a short description why is important
your contribution. 

### No programming skill?  

Don't worry we can help you, [create a free account on Github](https://github.com/join?source=header-home), then [create a issue](https://github.com/ccs-open-source/support-artists-project/issues/new) describing what
you want.

## MIT License

```
Copyright (c) [2020] [artist4artist]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

```

