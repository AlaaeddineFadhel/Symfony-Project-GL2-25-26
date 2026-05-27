/* ══════════════════════════════════════════
   INIT — pré-remplir le modal à l'ouverture
══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editProfileModal');
    if (!modal) return;

    modal.addEventListener('show.bs.modal', () => {
        loadSkillChips();
        loadExperienceRows();
        loadProjectRows();
        loadAchievementRows();
        initParcoursFilter();
    });

    // Sync nom/tagline en temps réel dans l'en-tête du modal
    document.getElementById('firstName')?.addEventListener('input', syncModalHeader);
    document.getElementById('lastName')?.addEventListener('input',  syncModalHeader);
    document.getElementById('editTagline')?.addEventListener('input', syncModalHeader);

    // Bouton Cancel — reset les listes dynamiques
    document.getElementById('cancelBtn')?.addEventListener('click', () => {
        bootstrap.Modal.getInstance(modal)?.hide();
    });
});

function initParcoursFilter() {
    const filiereSelect = document.getElementById('filiereSelect');
    const parcoursSelect = document.getElementById('parcoursSelect');
    if (!filiereSelect || !parcoursSelect) return;

    const options = Array.from(parcoursSelect.querySelectorAll('option'));

    function applyFilter() {
        const filiereId = filiereSelect.value;
        options.forEach(opt => {
            const optionFiliere = opt.dataset.filiereId || '';
            if (!optionFiliere) return;
            opt.hidden = filiereId !== '' && optionFiliere !== filiereId;
        });

        const selected = parcoursSelect.selectedOptions[0];
        if (selected && selected.hidden) {
            parcoursSelect.value = '';
        }
    }

    filiereSelect.addEventListener('change', applyFilter);
    parcoursSelect.addEventListener('change', () => {
        const selected = parcoursSelect.selectedOptions[0];
        const optionFiliere = selected?.dataset.filiereId || '';
        if (optionFiliere) {
            filiereSelect.value = optionFiliere;
        }
    });

    applyFilter();
}

function syncModalHeader() {
    const first = document.getElementById('firstName')?.value  || '';
    const last  = document.getElementById('lastName')?.value   || '';
    const tag   = document.getElementById('editTagline')?.value || '';
    const nameEl = document.getElementById('modalDisplayName');
    const tagEl  = document.getElementById('modalDisplayTagline');
    if (nameEl) nameEl.textContent = (first + ' ' + last).trim() || 'Votre nom';
    if (tagEl)  tagEl.textContent  = tag.trim() || 'Add a tagline';
}

/* ══════════════════════════════════════════
   SKILLS CHIPS
══════════════════════════════════════════ */
function loadSkillChips() {
    const container = document.getElementById('skills-chips');
    if (!container) return;
    container.innerHTML = '';

    let skills = [];
    try {
        skills = JSON.parse(container.dataset.skills || '[]');
    } catch (e) { skills = []; }

    skills.forEach(name => addSkillChipValue(name));
}

function addSkillChipValue(name) {
    if (!name || !name.trim()) return;
    const chips = document.getElementById('skills-chips');
    if (!chips) return;

    // Évite les doublons
    const existing = [...chips.querySelectorAll('.skill-chip')]
        .map(c => c.dataset.skill.toLowerCase());
    if (existing.includes(name.trim().toLowerCase())) return;

    const chip = document.createElement('span');
    chip.className = 'skill-chip';
    chip.dataset.skill = name.trim();
    chip.innerHTML = `${name.trim()}
        <button type="button" onclick="this.parentElement.remove()" aria-label="Remove skill">
            <i class="bi bi-x"></i>
        </button>`;
    chips.appendChild(chip);
}

function addSkillChip() {
    const input = document.getElementById('skillInput');
    if (!input) return;
    const val = input.value.trim();
    if (!val) return;
    addSkillChipValue(val);
    input.value = '';
    input.focus();
}

/* ══════════════════════════════════════════
   EXPERIENCE ROWS
══════════════════════════════════════════ */
function loadExperienceRows() {
    const list = document.getElementById('experience-list');
    if (!list) return;
    list.innerHTML = '';

    let items = [];
    try {
        items = JSON.parse(list.dataset.experiences || '[]');
    } catch (e) { items = []; }

    items.forEach(exp => {
        const div = createExperienceRow();
        div.querySelector('.exp-company').value = exp.entreprise      || '';
        div.querySelector('.exp-type').value    = exp.experience_type || 'job';
        div.querySelector('.exp-start').value   = exp.date_debut      || '';
        div.querySelector('.exp-end').value     = exp.date_fin        || '';
        div.querySelector('.exp-desc').value    = exp.description     || '';
        div.querySelector('.exp-link').value    = exp.lien            || '';
        list.appendChild(div);
    });
}

function createExperienceRow() {
    const div = document.createElement('div');
    div.className = 'item-row';
    div.innerHTML = `
        <div class="item-row-fields">
            <div class="row-inline">
                <input type="text" class="form-control exp-company" placeholder="Company">
                <select class="type-select exp-type">
                    <option value="job">Job</option>
                    <option value="internship">Internship</option>
                    <option value="freelance">Freelance</option>
                    <option value="certification">Certification</option>
                </select>
            </div>
            <div class="row-inline">
                <input type="date" class="form-control exp-start">
                <input type="date" class="form-control exp-end">
            </div>
            <input type="text" class="form-control exp-desc" placeholder="Description">
            <input type="text" class="form-control exp-link" placeholder="Lien (optionnel)">
        </div>
        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">
            <i class="bi bi-trash3"></i>
        </button>`;
    return div;
}

function addExperience() {
    const list = document.getElementById('experience-list');
    if (list) list.appendChild(createExperienceRow());
}

/* ══════════════════════════════════════════
   PROJECT ROWS
══════════════════════════════════════════ */
function loadProjectRows() {
    const list = document.getElementById('projects-list');
    if (!list) return;
    list.innerHTML = '';

    let items = [];
    try {
        items = JSON.parse(list.dataset.projects || '[]');
    } catch (e) { items = []; }

    items.forEach(proj => {
        const div = createProjectRow();
        div.querySelector('.proj-title').value = proj.title       || '';
        div.querySelector('.proj-desc').value  = proj.description || '';
        div.querySelector('.proj-start').value = proj.date_debut  || '';
        div.querySelector('.proj-end').value   = proj.date_fin    || '';
        div.querySelector('.proj-link').value  = proj.lien        || '';
        list.appendChild(div);
    });
}

function createProjectRow() {
    const div = document.createElement('div');
    div.className = 'item-row';
    div.innerHTML = `
        <div class="item-row-fields">
            <input type="text" class="form-control proj-title" placeholder="Titre du projet">
            <input type="text" class="form-control proj-desc"  placeholder="Description">
            <div class="row-inline">
                <input type="date" class="form-control proj-start">
                <input type="date" class="form-control proj-end">
            </div>
            <input type="text" class="form-control proj-link" placeholder="Lien (optionnel)">
        </div>
        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">
            <i class="bi bi-trash3"></i>
        </button>`;
    return div;
}

function addProject() {
    const list = document.getElementById('projects-list');
    if (list) list.appendChild(createProjectRow());
}

/* ══════════════════════════════════════════
   ACHIEVEMENT ROWS
══════════════════════════════════════════ */
function loadAchievementRows() {
    const list = document.getElementById('achievements-list');
    if (!list) return;
    list.innerHTML = '';

    let items = [];
    try {
        items = JSON.parse(list.dataset.achievements || '[]');
    } catch (e) { items = []; }

    items.forEach(ach => {
        const div = createAchievementRow();
        div.querySelector('.ach-title').value  = ach.title            || '';
        div.querySelector('.ach-issuer').value = ach.issuer           || '';
        div.querySelector('.ach-date').value   = ach.date_obtained    || '';
        div.querySelector('.ach-type').value   = ach.achievement_type || 'other';
        div.querySelector('.ach-desc').value   = ach.description      || '';
        div.querySelector('.ach-link').value   = ach.lien             || '';
        list.appendChild(div);
    });
}

function createAchievementRow() {
    const div = document.createElement('div');
    div.className = 'item-row';
    div.innerHTML = `
        <div class="item-row-fields">
            <input type="text" class="form-control ach-title" placeholder="Titre (ex: Hackathon Winner)">
            <div class="row-inline">
                <input type="text" class="form-control ach-issuer" placeholder="Organisme">
                <input type="date" class="form-control ach-date">
            </div>
            <select class="type-select ach-type">
                <option value="award">Award</option>
                <option value="honour">Honour</option>
                <option value="publication">Publication</option>
                <option value="competition">Competition</option>
                <option value="other">Other</option>
            </select>
            <input type="text" class="form-control ach-desc" placeholder="Description">
            <input type="text" class="form-control ach-link" placeholder="Lien (optionnel)">
        </div>
        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">
            <i class="bi bi-trash3"></i>
        </button>`;
    return div;
}

function addAchievement() {
    const list = document.getElementById('achievements-list');
    if (list) list.appendChild(createAchievementRow());
}

/* ══════════════════════════════════════════
   AVATAR UPLOAD
══════════════════════════════════════════ */
async function uploadAvatarImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('avatar', file);

    try {
        const res = await fetch('/api/upload_avatar.php', {
            method: 'POST',
            credentials: 'include',
            body: formData
        });
        const data = await res.json();

        if (data.ok && data.avatarUrl) {
            const modalImg = document.getElementById('modalAvatarImg');
            if (modalImg) modalImg.src = data.avatarUrl;
            // Met aussi à jour l'avatar affiché sur la page (id défini dans profil.php)
            const pageImg = document.querySelector('.profile-pic');
            if (pageImg) pageImg.src = data.avatarUrl;
        } else {
            alert('Upload échoué : ' + (data.message || 'Erreur inconnue'));
        }
    } catch (e) {
        console.error(e);
        alert('Erreur réseau lors de l\'upload.');
    }
}

/* ══════════════════════════════════════════
   SAVE PROFILE — POST form natif vers myprofile.php
══════════════════════════════════════════ */
function saveProfile() {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    // Créer un <form> dynamique et le soumettre en POST standard
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'myprofile.php';

    function addField(name, value) {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = name;
        input.value = value ?? '';
        form.appendChild(input);
    }

    // Champs simples
    addField('prenom',       document.getElementById('firstName')?.value.trim());
    addField('nom',          document.getElementById('lastName')?.value.trim());
    addField('bio',          document.getElementById('editBio')?.value.trim());
    addField('promo_year',   document.getElementById('promoYear')?.value.trim());
    addField('parcours_id',  document.getElementById('parcoursSelect')?.value);
    addField('tagline',      document.getElementById('editTagline')?.value.trim());
    addField('github_link',  document.getElementById('githubLink')?.value.trim());
    addField('linkedin_link',document.getElementById('linkedinLink')?.value.trim());
    addField('profile_link', document.getElementById('editProfileLink')?.value.trim());

    // Skills — tableau : skills[]
    document.querySelectorAll('#skills-chips .skill-chip').forEach(chip => {
        if (chip.dataset.skill) addField('skills[]', chip.dataset.skill);
    });

    // Experiences — tableaux indexés : experiences[0][entreprise], etc.
    document.querySelectorAll('#experience-list .item-row').forEach((row, i) => {
        addField(`experiences[${i}][entreprise]`,      row.querySelector('.exp-company')?.value.trim());
        addField(`experiences[${i}][experience_type]`, row.querySelector('.exp-type')?.value);
        addField(`experiences[${i}][date_debut]`,      row.querySelector('.exp-start')?.value);
        addField(`experiences[${i}][date_fin]`,        row.querySelector('.exp-end')?.value);
        addField(`experiences[${i}][description]`,     row.querySelector('.exp-desc')?.value.trim());
        addField(`experiences[${i}][lien]`,            row.querySelector('.exp-link')?.value.trim());
    });

    // Projects
    document.querySelectorAll('#projects-list .item-row').forEach((row, i) => {
        addField(`projects[${i}][title]`,       row.querySelector('.proj-title')?.value.trim());
        addField(`projects[${i}][description]`, row.querySelector('.proj-desc')?.value.trim());
        addField(`projects[${i}][date_debut]`,  row.querySelector('.proj-start')?.value);
        addField(`projects[${i}][date_fin]`,    row.querySelector('.proj-end')?.value);
        addField(`projects[${i}][lien]`,        row.querySelector('.proj-link')?.value.trim());
    });

    // Achievements
    document.querySelectorAll('#achievements-list .item-row').forEach((row, i) => {
        addField(`achievements[${i}][title]`,            row.querySelector('.ach-title')?.value.trim());
        addField(`achievements[${i}][issuer]`,           row.querySelector('.ach-issuer')?.value.trim());
        addField(`achievements[${i}][date_obtained]`,    row.querySelector('.ach-date')?.value);
        addField(`achievements[${i}][achievement_type]`, row.querySelector('.ach-type')?.value);
        addField(`achievements[${i}][description]`,      row.querySelector('.ach-desc')?.value.trim());
        addField(`achievements[${i}][lien]`,             row.querySelector('.ach-link')?.value.trim());
    });

    document.body.appendChild(form);
    form.submit();
}
