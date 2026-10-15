<?php
/**
 * Resume Builder
 * Self-contained PHP resume builder. Zero dependencies.
 * Drop it on any PHP host and go.
 * Bryan Hamilton -- https://github.com/bryanhamiltondev/resume-builder
 */

// --- 1. FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $type     = ($_POST['type'] ?? 'tech') === 'retail' ? 'retail' : 'tech';
    $manager  = trim($_POST['manager'] ?? '');
    $company  = trim($_POST['company'] ?? '');
    $role     = trim($_POST['role'] ?? '');
    $location = trim($_POST['location'] ?? '');
    if ($manager === '') $manager = 'Hiring Manager';
    if ($company === '') $company = '[Company]';

    $pdf = new ResumePDF($type, $manager, $company, $role, $location);
    $data = $pdf->output();
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="bryan-hamilton-' . $type . '-' . date('Y-m-d') . '.pdf"');
    header('Content-Length: ' . strlen($data));
    echo $data;
    exit;
}

// --- 2. FORM HTML ---
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resume Builder -- Bryan Hamilton</title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background:#0a0a0f;color:#e4e6eb;line-height:1.6;min-height:100vh;display:flex;align-items:center;justify-content:center}
.container{max-width:540px;width:100%;margin:40px 20px;background:#12121a;border:1px solid #21212e;border-radius:16px;padding:40px}
h1{font-size:22px;font-weight:800;margin-bottom:4px;color:#f0f6fc}
h1 span{color:#00d2ff}
p.sub{font-size:13px;color:#8b949e;margin-bottom:28px}
.form-group{margin-bottom:20px}
label{display:block;font-size:12px;font-weight:600;color:#8b949e;letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px}
select,input[type="text"]{width:100%;padding:10px 14px;background:#0e0e16;border:1px solid #30304a;border-radius:8px;color:#e4e6eb;font-size:14px;transition:border-color .2s;font-family:inherit}
select:focus,input[type="text"]:focus{outline:none;border-color:#00d2ff;box-shadow:0 0 0 3px rgba(0,210,255,.12)}
input::placeholder{color:#484f58}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:480px){.form-row{grid-template-columns:1fr}}
.btn{width:100%;padding:12px;background:#00d2ff;color:#0a0a0f;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;transition:all .25s;margin-top:8px}
.btn:hover{background:#33ddff;transform:translateY(-1px);box-shadow:0 4px 20px rgba(0,210,255,.25)}
.btn:active{transform:translateY(0)}
.footer{text-align:center;margin-top:24px;font-size:11px;color:#30304a}
.footer a{color:#00d2ff;text-decoration:none}
.template-preview{background:#0e0e16;border:1px solid #1a1a28;border-radius:10px;padding:16px;margin-bottom:24px;font-size:12px;color:#8b949e;line-height:1.5}
.template-preview strong{color:#c9d1d9}
</style>
</head>
<body>
<div class="container">
  <h1><span>//</span> Resume Builder</h1>
  <p class="sub">Pick a template, fill in the details, get a finished PDF.</p>
  <div class="template-preview">
    <strong>Tech resume:</strong> Cover letter + full-stack engineer resume (29 years, 10 repos).<br>
    <strong>Retail resume:</strong> Cover letter + customer service resume (Shake Shack, Wawa, ShopRite).
  </div>
  <form method="post">
    <div class="form-group">
      <label for="type">Resume type</label>
      <select name="type" id="type">
        <option value="tech">Tech -- Full-Stack Engineer</option>
        <option value="retail">Retail -- Customer Service</option>
      </select>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label for="manager">Hiring manager name</label>
        <input type="text" name="manager" id="manager" placeholder="e.g. Sarah Chen" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="company">Company name</label>
        <input type="text" name="company" id="company" placeholder="e.g. Acme Corp" autocomplete="off">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label for="role">Role / Position</label>
        <input type="text" name="role" id="role" placeholder="e.g. Senior PHP Developer" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="location">Job location</label>
        <input type="text" name="location" id="location" placeholder="e.g. New York, NY" autocomplete="off">
      </div>
    </div>
    <button type="submit" name="generate" class="btn">Generate PDF</button>
  </form>
  <div class="footer">
    <a href="https://github.com/bryanhamiltondev/resume-builder">GitHub</a> &middot;
    Bryan Hamilton &middot; Rochelle Park, NJ
  </div>
</div>
</body>
</html>
<?php

// ===========================================================================
// 3. RESUME CONTENT DATA
// ===========================================================================

function resume_content($type) {
    if ($type === 'retail') {
        return [
            'name'     => 'Bryan Hamilton',
            'title'    => 'Customer Service Professional / Tech-Savvy Team Member',
            'phone'    => '(201) 406-3595',
            'email'    => 'bryan_hamilton@me.com',
            'location' => 'Rochelle Park, NJ',
            'profile'  => [
                'Reliable, customer-focused team member with hands-on experience across multiple fast-paced food service and retail brands. I bring a strong work ethic, a calm demeanor during rush periods, and a genuine commitment to keeping operations smooth and guests satisfied.',
                'Behind the register, I also carry nearly three decades of technical experience -- from enterprise web platforms to large-scale CMS systems. That background means I learn new POS and digital systems quickly, troubleshoot basic tech issues, and adapt fast to whatever tools the team uses.'
            ],
            'skills' => [
                'POS Systems & Cash Handling', 'Order Accuracy & Speed',
                'Front-of-House / Back-of-House', 'Multi-tasking Under Pressure',
                'Team Collaboration', 'Cleaning & Safety Protocols',
                'Guest Satisfaction Focus', 'Flexible Scheduling'
            ],
            'experience' => [
                ['title'=>'Team Member -- Consolidated Experience','org'=>'Shake Shack, Wawa, Chick-fil-A, Dunkin, ShopRite','loc'=>'New Jersey','bullets'=>[
                    'Developed a strong foundation in fast-paced customer service and operations across multiple food-service brands.',
                    'Took and prepared orders with accuracy and efficiency; delivered orders to guests with a welcoming, attentive presence.',
                    'Handled cash and POS systems accurately; comfortable with digital ordering, kiosks, and register workflows.',
                    'Kept shelves and cases rotated first-in, first-out; took ownership of cleaning tasks to maintain a safe, inviting environment.',
                    'Worked breakfast rushes, lunch floods, and closing shifts -- kept the line moving, the station clean, and the team in sync.',
                    'Approached every shift with a genuine smile and positive attitude, prioritizing guest satisfaction and team support.'
                ]],
                ['title'=>'Founder & Lead Developer','org'=>'The DJ Calendar, LLC','loc'=>'New Jersey','date'=>'Apr 2015 -- Present','bullets'=>[
                    'Build and operate a live event-discovery platform -- scheduling, uptime, and customer communication are daily work.',
                    'Deep experience with the digital tools retail teams rely on: POS integrations, online ordering, and scheduling systems.'
                ]],
                ['title'=>'Teacher & Lead Moderator','org'=>'Meta -- Facebook Groups','loc'=>'New Jersey','date'=>'Mar 2023 -- Present','bullets'=>[
                    'Lead moderator and educator for a 214K+ member global community; promoted to lead within one week.',
                    'De-escalate conflicts, keep the space welcoming, and guide members day to day -- people skills at scale.'
                ]]
            ],
            'earlier'    => 'Earlier Career -- Web Engineering (1997-2022): OUTFRONT Media, Cellebrite, Jackson Hewitt, NY Daily News, KPMG/BearingPoint',
            'education'  => 'Quinnipiac University -- Interactive Digital Design (IDD) 2001-2003 / Interwoven TeamSite Certified',
            'cover_letter' => [
                'Dear @@MANAGER@@,', '',
                'I am applying for @@ROLE@@ at @@COMPANY@@. I am a friendly, dependable worker who shows up on time, keeps a smile under pressure, and genuinely enjoys helping people have a good day.', '',
                'I have spent years in retail and food service -- most recently the meat department at ShopRite, and before that registers and prep at places like Walmart and Dunkin. So I am comfortable wherever you need me: running the register on various POS systems with fast, accurate cash handling; prepping hot food and cold drinks during a rush without letting quality slip; and keeping shelves and cases rotated first-in, first-out so customers always get fresh product and nothing goes to waste.', '',
                'What I have learned behind counters and registers is simple: customers remember how you made them feel. I greet people, I listen, I answer questions, and if I don not know something, I find out. I keep my station clean, I follow food-safety procedures to the letter, and I am happy to jump wherever the shift needs me -- registers, prep, stocking, dining room, or dishes.', '',
                'I am flexible with scheduling, including nights, weekends, and holidays, and I take pride in being someone a manager never has to chase. I am looking for steady, long-term work close to home -- not a stopgap -- and I would love to bring that energy to @@COMPANY@@\'s team.', '',
                'Thank you for your time and consideration. I hope to hear from you soon.', '',
                'Sincerely,', 'Bryan Hamilton'
            ]
        ];
    }

    // Tech resume
    return [
        'name'     => 'Bryan Hamilton',
        'title'    => 'Full-Stack Software Engineer / Founder, The DJ Calendar',
        'phone'    => '(201) 406-3595',
        'email'    => 'bryan_hamilton@me.com',
        'github'   => 'github.com/bryanhamiltondev',
        'location' => 'Rochelle Park, NJ',
        'profile'  => [
            'Full-stack web engineer and founder with 29 years across enterprise newsrooms, advertising technology, a global digital intelligence leader (Cellebrite), financial services, and founder-led agencies. Expert in HTML5/CSS3 with deep hands-on work in JavaScript, PHP, MySQL, and large-scale CMS platforms. Comfortable from C-suite conversations to sprint planning -- producing accurate, high-quality work under strict deadlines while mentoring teams and documenting systems for the next generation of developers.'
        ],
        'skills' => [
            'PHP / MySQL / PDO', 'Vanilla JavaScript (no frameworks)',
            'HTML5 / CSS3', 'WordPress (21 yrs) / ACF / WP-CLI',
            'schema.org / JSON-LD / SEO', 'Web Audio API / Leaflet / CARTO',
            'Git / GitHub Actions CI', 'REST APIs / data ingestion',
            'Java / IBM i / SQL'
        ],
        'oss_repos' => [
            'dj-card-preview -- hover-preview card: iTunes 30s audio, Web Audio analyser EQ, consent-first contract.',
            'instant-search-index -- prebuilt JSON index, weighted scoring, ARIA combobox; site search with zero round-trips.',
            'tour-feed-pipeline -- Bandsintown + Ticketmaster normalized, deduped, cached; CI on PHP 8.1/8.3.',
            'jsonld-schema-audit -- PHP CLI auditing JSON-LD; fails CI on regressions.',
            'csrf-json-fetch -- CSRF-safe fetch: token lifecycle, dual injection, single-retry policy.',
            'sri-lazy-loader -- race-safe SRI lazy loader with dedupe and timeout cleanup.',
            'event-calendar-schema -- MySQL/PDO layer: idempotent upserts, double opt-in, query-shaped indexes.',
            'next-show-radar -- consent-first geolocation tour map; documented deny contract.',
            'eq-visualizer -- pure-CSS 8-bar equalizer with reduced-motion respect.',
            'wp-schema-audit -- WordPress port: WP-CLI, admin Tools page, fixture-driven CI self-test.'
        ],
        'experience' => [
            ['title'=>'Founder & Lead Developer','org'=>'The DJ Calendar, LLC','loc'=>'New Jersey','date'=>'Apr 2015 -- Present','bullets'=>[
                'Designed, built, and operate thedjcalendar.com: PHP/MySQL back end, caching layers, and automated data ingestion for ~1,000 schema.org-rich pages.',
                'Site-wide JSON-LD (MusicEvent, MusicGroup, Organization, FAQPage) plus a custom audit tool -- zero Rich Results warnings.',
                'Leaflet/CARTO mapping: geocoded tour dates, city hubs, and a global artist search index; MySQL/PDO double opt-in subscriber system on SPF/DKIM/DMARC-aligned sending.',
                'Organic growth via dynamic sitemaps, sitelinks search box markup, and Knowledge Graph entity strategy.'
            ]],
            ['title'=>'Teacher & Lead Moderator','org'=>'Meta -- Facebook Groups','loc'=>'New Jersey','date'=>'Mar 2023 -- Present','bullets'=>[
                'Lead moderator and educator for a 214K+ member global community; promoted to lead within one week.',
                'Built programming around proof-of-concept direction and employment readiness.'
            ]],
            ['title'=>'Web Application Developer','org'=>'OUTFRONT Media','loc'=>'New York City Metro','date'=>'Feb 2019 -- May 2022','bullets'=>[
                'Delivered desktop and mobile-compatible applications for one of the largest out-of-home advertising networks in North America.',
                'Stack: IBM Rational Developer for i, Power9 IBM i, Java, PHP, SQL, JavaScript, jQuery, HTML5/CSS.'
            ]],
            ['title'=>'Front-End Developer','org'=>'Cellebrite','loc'=>'Parsippany, NJ','date'=>'Oct 2018 -- Jan 2019','bullets'=>[
                'Engineered a modular WordPress back end with Advanced Custom Fields enabling rapid page construction across cellebrite.com; maintained Eloqua integrations.'
            ]],
            ['title'=>'Web Developer','org'=>'Jackson Hewitt Tax Service','loc'=>'Jersey City, NJ','date'=>'Mar 2017 -- Feb 2018','bullets'=>[
                'Recommended and oversaw the CMS migration from Ektron to EpiServer; restructured the site with the marketing team; converted PSD/Sketch to HTML/CSS (Bootstrap 3/4); wrote new-hire onboarding documentation.'
            ]],
            ['title'=>'Web Developer','org'=>'NY Daily News','loc'=>'New York, NY','date'=>'Oct 2004 -- Nov 2016','bullets'=>[
                'Operated Polopoly, the CMS for one of the five largest newspaper websites in the U.S.; integral to four full site redesigns.',
                'Built content XML, Velocity/Java output templates, PHP modules, Interwoven TeamSite templates, and complex JavaScript/jQuery; provided 24/7 CMS and support.'
            ]],
            ['title'=>'Web & Database Support','org'=>'KPMG / BearingPoint','loc'=>'Montvale, NJ','date'=>'Sep 1997 -- Oct 2004','bullets'=>[
                'Maintained global travel services web properties; built Access and Lotus Notes databases and automated complex Excel reporting with VBA.'
            ]]
        ],
        'education' => 'Quinnipiac University -- Interactive Digital Design (IDD) 2001-2003 / Interwoven TeamSite Certified',
        'cover_letter' => [
            'Dear @@MANAGER@@,', '',
            'I am a full-stack engineer and entrepreneur with 29 years of experience building, maintaining, and migrating web platforms at the scale of the New York Daily News, OUTFRONT Media, Jackson Hewitt, and Cellebrite. I have shipped four full redesigns of a top-five U.S. newspaper website, led a CMS migration from Ektron to EpiServer, and built modular WordPress systems that marketing teams still use years later.', '',
            'I also run my own production platform: thedjcalendar.com, an electronic music event discovery site with about 1,000 pages of structured data. It took hundreds of Rich Results warnings to zero with a custom JSON-LD audit pipeline, and it now powers ten production-verbatim open-source repositories -- instant search, Web Audio tooling, security utilities, and a tour-feed ingestion pipeline, all CI-tested and zero-dependency (github.com/bryanhamiltondev).', '',
            'My background spans IBM i / Java back-ends at a Fortune 500 advertising network to AI-assisted front-end development on my own venture. I am comfortable in C-suite conversations, fluent in Agile workflows, and obsessive about documentation that survives the next developer. I do not just write code -- I own the outcome, mentor teams, and make sure projects ship on time without shortcuts that create debt.', '',
            'I am based in New Jersey and open to remote or hybrid opportunities where I can bring that same production-hardened reliability to @@COMPANY@@. I would welcome the chance to show you what I have built and discuss how I can contribute from day one.', '',
            'Thank you for your time and consideration. I hope to hear from you soon.', '',
            'Sincerely,', 'Bryan Hamilton'
        ]
    ];
}

// ===========================================================================
// 4. RAW PDF GENERATOR (zero dependencies)
// ===========================================================================

class ResumePDF {
    private $pages = [], $curPage = 0;
    private $x, $y, $lm=50, $rm=50, $tm=50, $bm=50;
    private $pw=612, $ph=792;
    private $font='Helvetica', $size=10;
    private $type, $manager, $company, $role, $location, $data;

    public function __construct($t,$m,$c,$r,$l) {
        $this->type=$t; $this->manager=$m; $this->company=$c; $this->role=$r; $this->location=$l;
        $this->data = resume_content($t);
        $this->addPage();
        $this->buildCoverLetter();
        $this->addPage();
        $this->buildResume();
    }

    private function addPage() {
        $this->curPage = count($this->pages);
        $this->pages[] = '';
        $this->x = $this->lm; $this->y = $this->tm;
    }

    private function sf($f,$s) { $this->font=$f; $this->size=$s; }

    private function tw($t) { return strlen($t)*$this->size*0.55; }

    private function wl($t,$s,$b) {
        $f=$b?'Helvetica-Bold':'Helvetica';
        $this->pages[$this->curPage] .= sprintf("BT /%s %.1f Tf %.1f %.1f Td (%s) Tj ET\n",$f,$s,$this->x,$this->ph-$this->y-$s,$this->es($t));
        $this->y += $s*1.2;
    }

    private function es($s) {
        $s=str_replace(['\\\\','(',')'],['\\\\\\\\','\(','\)'],$s);
        $s=html_entity_decode($s,ENT_QUOTES|ENT_HTML5,'UTF-8');
        $o='';for($i=0;$i<strlen($s);$i++){$c=$s[$i];$o=ord($c)>=32&&ord($c)<=126?$o.$c:$o;}return $o;
    }

    private function w($t,$s=10,$b=false) {
        $this->sf($b?'Helvetica-Bold':'Helvetica',$s);
        $mw=$this->pw-$this->lm-$this->rm;
        $ws=explode(' ',$t);$ln='';
        foreach($ws as $wd){
            $tst=$ln===''?$wd:$ln.' '.$wd;
            if($this->tw($tst)>$mw&&$ln!==''){$this->wl($ln,$s,$b);$ln=$wd;}
            else $ln=$tst;
        }
        if($ln!=='')$this->wl($ln,$s,$b);
    }

    private function sp($p=8){$this->y+=$p;}
    private function sep(){
        $y=$this->ph-$this->y;
        $this->pages[$this->curPage].=sprintf("%.1f %.1f m %.1f %.1f l S\n",$this->lm,$y,$this->pw-$this->rm,$y);
        $this->y+=4;
    }

    private function cpb($n=30){if($this->y+$n>$this->ph-$this->bm)$this->addPage();}

    private function buildCoverLetter(){
        $d=$this->data;
        $this->wl($d['name'],18,1);$this->sp(4);
        $c=$d['location'].'  |  '.$d['phone'].'  |  '.$d['email'];
        $this->wl($c,9,0);$this->sp(6);$this->sep();$this->sp(12);
        $this->wl(date('F j, Y'),10,0);$this->sp(14);
        $this->w('Dear '.$this->manager.',',10,0);$this->sp(10);
        foreach($d['cover_letter'] as $ln){ if($ln==='Dear @@MANAGER@@,')continue;
            $ln=str_replace(['@@MANAGER@@','@@COMPANY@@','@@ROLE@@','@@LOCATION@@'],[$this->manager,$this->company,$this->role,$this->location],$ln);
            if($ln===''){$this->sp(6);continue;}
            $this->cpb(20);$this->w($ln,10,0);$this->sp(2);
        }
    }

    private function buildResume(){
        $d=$this->data;
        $this->wl($d['name'],20,1);$this->sp(3);
        $this->wl($d['title'],11,0);$this->sp(4);
        $c=$d['location'].'  |  '.$d['phone'].'  |  '.$d['email'];
        if(isset($d['github']))$c.='  |  '.$d['github'];
        $this->wl($c,8.5,0);$this->sp(3);$this->sep();$this->sp(8);
        $this->sh('Profile');
        foreach($d['profile'] as $p){$this->w($p,9.5,0);$this->sp(3);}
        $this->sp(6);
        $this->sh('Core Skills');
        $this->w(implode('  |  ',$d['skills']),9,0);$this->sp(8);
        if(isset($d['oss_repos'])){
            $this->cpb(40);$this->sh('Open Source -- Ten Production-Verbatim Repositories');
            foreach($d['oss_repos'] as $r){$this->cpb(12);$this->w('  '.$r,9,0);$this->sp(2);}
            $this->sp(6);
        }
        $this->cpb(30);$this->sh('Experience');
        foreach($d['experience'] as $e){
            $this->cpb(30);
            $tl=$e['title'];if(isset($e['date']))$tl.='  --  '.$e['date'];
            $this->wl($tl,10,1);
            $ol=$e['org'];if(isset($e['loc']))$ol.='  |  '.$e['loc'];
            $this->wl($ol,9,0);$this->sp(2);
            foreach($e['bullets'] as $b){$this->cpb(12);$this->w('  '.$b,9,0);$this->sp(1);}
            $this->sp(6);
        }
        if(isset($d['earlier'])){$this->cpb(15);$this->w($d['earlier'],9,0);$this->sp(8);}
        $this->cpb(15);$this->sh('Education & Certification');$this->w($d['education'],9,0);
    }

    private function sh($t){
        $y=$this->ph-$this->y-1;
        $this->pages[$this->curPage].=sprintf("%.1f %.1f m %.1f %.1f l S\n",$this->lm,$y,$this->lm+40,$y);
        $this->wl($t,11,1);$this->sp(4);
    }

    public function output(){
        $buf="%PDF-1.4\n";$offsets=[];$n=1;
        $fonts=['Helvetica'=>'Helvetica','Helvetica-Bold'=>'Helvetica-Bold'];
        $fontAliases=[];$fontNums=[];
        foreach($fonts as $a=>$bf){$fontAliases[$a]=$bf;$fontNums[$a]=0;}
        $catalogN=1;$pagesN=2;
        $pageNs=[];$streamNs=[];
        $c=3;
        for($i=0;$i<count($this->pages);$i++){$pageNs[$i]=$c++;$streamNs[$i]=$c++;}
        foreach($fonts as $a=>$bf){$fontNums[$a]=$c++;}
        $fdp=[];foreach($fonts as $a=>$bf){$fdp[]="/$a {$fontNums[$a]} 0 R";}
        $fd='<< /Font << '.implode(' ',$fdp).'>> >>';
        $o=function($n,$c)use(&$buf,&$offsets){$offsets[$n]=strlen($buf);$buf.="$n 0 obj\n$c\nendobj\n";};
        $o($catalogN,'<< /Type /Catalog /Pages '.$pagesN.' 0 R >>');
        $kids=[];foreach($pageNs as $pn){$kids[]="$pn 0 R";}
        $o($pagesN,'<< /Type /Pages /Kids ['.implode(' ',$kids).'] /Count '.count($this->pages).' >>');
        foreach($this->pages as $i=>$ct){
            $len=strlen($ct);$so="<< /Length $len >>\nstream\n$ct\nendstream";
            $o($streamNs[$i],$so);
            $o($pageNs[$i],'<< /Type /Page /Parent '.$pagesN.' 0 R /MediaBox [0 0 '.$this->pw.' '.$this->ph.'] /Contents '.$streamNs[$i].' 0 R /Resources '.$fd.' >>');
        }
        foreach($fonts as $a=>$bf){$o($fontNums[$a],'<< /Type /Font /Subtype /Type1 /BaseFont /'.$bf.' >>');}
        $sx=strlen($buf);$buf.="xref\n0 $c\n0000000000 65535 f \n";
        for($i=1;$i<$c;$i++){$buf.=sprintf("%010d 00000 n \n",$offsets[$i]??0);}
        $buf.="trailer\n<< /Size $c /Root $catalogN 0 R >>\nstartxref\n$sx\n%%EOF\n";
        return $buf;
    }
}
