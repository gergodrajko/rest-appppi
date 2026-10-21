<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Laravel')); ?> | CRUD dashboard</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 20px; background: #f5f6f7; color: #202a35; font-family: Arial, sans-serif; font-size: 14px; }
        button, input, select { font: inherit; }
        button { cursor: pointer; }
        .container { width: 100%; max-width: 1080px; margin: 0 auto; }
        .header { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; margin-bottom: 22px; }
        h1 { margin: 0; font-size: 27px; }
        h2 { margin: 0; font-size: 17px; }
        p { color: #657180; }
        .subtitle { margin: 7px 0 0; }
        .card { margin-bottom: 18px; padding: 20px; border: 1px solid #e1e5e9; border-radius: 9px; background: #fff; }
        .auth-form { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 10px; }
        .auth-form[hidden] { display: none; }
        .field { display: grid; min-width: 0; flex: 1; gap: 6px; color: #4d5966; font-size: 12px; font-weight: 600; }
        input, select { min-height: 37px; width: 100%; padding: 8px 10px; border: 1px solid #d7dde3; border-radius: 6px; background: #fff; color: #202a35; }
        input:focus, select:focus { border-color: #6389ac; outline: 2px solid #dce9f4; }
        .button { min-height: 36px; padding: 8px 12px; border: 1px solid #d5dbe1; border-radius: 6px; background: #fff; color: #334150; font-size: 12px; font-weight: 600; }
        .button:hover:not(:disabled) { background: #f2f5f7; }
        .button:disabled { cursor: not-allowed; opacity: .5; }
        .button.primary { border-color: #326846; background: #326846; color: #fff; }
        .button.primary:hover:not(:disabled) { background: #28563a; }
        .button.danger { border-color: #edd6d6; color: #a23f3f; }
        .auth-note { margin: 10px 0 0; font-size: 12px; }
        [data-message]:empty { display: none; }
        [data-message] { margin: 10px 0 0; font-size: 12px; }
        [data-message][data-error="true"] { color: #a23f3f; }
        [data-message][data-error="false"] { color: #326846; }
        .section-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 11px 10px; border-bottom: 1px solid #edf0f2; }
        th { color: #697685; font-size: 11px; font-weight: 700; }
        td { color: #35414e; font-size: 13px; }
        tbody tr:last-child td { border-bottom: 0; }
        .actions { display: flex; justify-content: flex-end; gap: 7px; }
        .empty-row { padding: 24px 10px; color: #697685; text-align: center; }
        dialog { width: min(420px, calc(100% - 32px)); padding: 0; border: 0; border-radius: 9px; box-shadow: 0 12px 50px #18253433; }
        dialog::backdrop { background: #17212b88; }
        .dialog-content { display: grid; gap: 14px; padding: 22px; }
        .dialog-actions { display: flex; justify-content: flex-end; gap: 8px; margin-top: 4px; }
        fieldset { display: grid; gap: 12px; min-width: 0; margin: 0; padding: 0; border: 0; }
        fieldset[hidden] { display: none; }
        @media (max-width: 640px) {
            body { padding: 22px 12px; }
            .header { flex-direction: column; }
            .card { padding: 15px; }
            .section-header { align-items: flex-start; }
            th, td { padding-right: 8px; padding-left: 8px; }
        }
    </style>
</head>
<body>
    <main class="container">
        <header class="header">
            <div>
                <h1>CRUD dashboard</h1>
                <p class="subtitle">Manage cities and counties.</p>
            </div>
            <button class="button" type="button" data-logout hidden>Sign out</button>
        </header>

        <section class="card" aria-label="API sign in">
            <form class="auth-form" data-login-form>
                <label class="field">
                    Email
                    <input name="email" type="email" autocomplete="username" required>
                </label>
                <label class="field">
                    Password
                    <input name="password" type="password" autocomplete="current-password" required>
                </label>
                <button class="button primary" type="submit">Sign in</button>
            </form>
            <p class="auth-note" data-login-note>Sign in with your API account to create, edit, or delete records. Viewing records does not require signing in.</p>
            <p data-message role="status" aria-live="polite"></p>
        </section>

        <section class="card" aria-labelledby="cities-heading">
            <div class="section-header">
                <h2 id="cities-heading">Cities (<?php echo e($cities->count()); ?>)</h2>
                <button class="button primary" type="button" data-requires-auth data-create="cities" disabled>Add city</button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Postal code</th>
                            <th scope="col">Population</th>
                            <th scope="col">County</th>
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($city->name); ?></td>
                                <td><?php echo e($city->zip_code); ?></td>
                                <td><?php echo e(number_format($city->population)); ?></td>
                                <td><?php echo e($city->county?->name ?? 'Unassigned'); ?></td>
                                <td>
                                    <div class="actions">
                                        <button class="button" type="button" data-requires-auth data-edit="cities"
                                            data-id="<?php echo e($city->id); ?>" data-name="<?php echo e($city->name); ?>"
                                            data-zip-code="<?php echo e($city->zip_code); ?>" data-population="<?php echo e($city->population); ?>"
                                            data-county-id="<?php echo e($city->county_id); ?>" disabled>Edit</button>
                                        <button class="button danger" type="button" data-requires-auth data-delete="cities"
                                            data-id="<?php echo e($city->id); ?>" data-name="<?php echo e($city->name); ?>" disabled>Delete</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td class="empty-row" colspan="5">No cities found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card" aria-labelledby="counties-heading">
            <div class="section-header">
                <h2 id="counties-heading">Counties (<?php echo e($counties->count()); ?>)</h2>
                <button class="button primary" type="button" data-requires-auth data-create="counties" disabled>Add county</button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Cities</th>
                            <th scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($county->name); ?></td>
                                <td><?php echo e($county->cities_count); ?></td>
                                <td>
                                    <div class="actions">
                                        <button class="button" type="button" data-requires-auth data-edit="counties"
                                            data-id="<?php echo e($county->id); ?>" data-name="<?php echo e($county->name); ?>"
                                            data-badge-url="<?php echo e($county->badge_url); ?>" disabled>Edit</button>
                                        <button class="button danger" type="button" data-requires-auth data-delete="counties"
                                            data-id="<?php echo e($county->id); ?>" data-name="<?php echo e($county->name); ?>"
                                            data-city-count="<?php echo e($county->cities_count); ?>" disabled>Delete</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td class="empty-row" colspan="3">No counties found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <dialog data-record-dialog aria-labelledby="dialog-title">
        <form class="dialog-content" data-record-form>
            <h2 id="dialog-title" data-dialog-title>Add record</h2>
            <fieldset data-city-fields>
                <label class="field">City name<input name="city_name" required maxlength="191"></label>
                <label class="field">Postal code<input name="zip_code" type="number" min="1000" max="9999" step="1" required></label>
                <label class="field">Population<input name="population" type="number" min="0" step="1" required></label>
                <label class="field">County
                    <select name="county_id" required>
                        <option value="">Choose a county</option>
                        <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($county->id); ?>"><?php echo e($county->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
            </fieldset>
            <fieldset data-county-fields hidden>
                <label class="field">County name<input name="county_name" required maxlength="191"></label>
                <label class="field">Badge URL<input name="badge_url" type="url" required></label>
            </fieldset>
            <div class="dialog-actions">
                <button class="button" type="button" data-close-dialog>Cancel</button>
                <button class="button primary" type="submit">Save</button>
            </div>
        </form>
    </dialog>

    <script>
        const apiUrls = <?php echo e(\Illuminate\Support\Js::from([
            'login' => url('/api/login'),
            'cities' => url('/api/cities'),
            'counties' => url('/api/counties'),
        ])); ?>;
        const tokenKey = 'city-atlas-api-token';
        const loginForm = document.querySelector('[data-login-form]');
        const logoutButton = document.querySelector('[data-logout]');
        const message = document.querySelector('[data-message]');
        const dialog = document.querySelector('[data-record-dialog]');
        const recordForm = document.querySelector('[data-record-form]');
        const cityFields = document.querySelector('[data-city-fields]');
        const countyFields = document.querySelector('[data-county-fields]');
        const dialogTitle = document.querySelector('[data-dialog-title]');
        let token = sessionStorage.getItem(tokenKey);
        let activeResource = '';
        let activeRecordId = '';

        function showMessage(text, isError = false) {
            message.textContent = text;
            message.dataset.error = String(isError);
        }

        function updateAuthState() {
            loginForm.hidden = Boolean(token);
            logoutButton.hidden = !token;
            document.querySelectorAll('[data-requires-auth]').forEach((button) => {
                button.disabled = !token;
            });
        }

        function openRecordDialog(resource, record = null) {
            activeResource = resource;
            activeRecordId = record?.id ?? '';
            recordForm.reset();
            cityFields.hidden = resource !== 'cities';
            cityFields.disabled = resource !== 'cities';
            countyFields.hidden = resource !== 'counties';
            countyFields.disabled = resource !== 'counties';
            dialogTitle.textContent = `${record ? 'Edit' : 'Add'} ${resource === 'cities' ? 'city' : 'county'}`;

            if (record) {
                if (resource === 'cities') {
                    recordForm.elements.city_name.value = record.name;
                    recordForm.elements.zip_code.value = record.zipCode;
                    recordForm.elements.population.value = record.population;
                    recordForm.elements.county_id.value = record.countyId;
                } else {
                    recordForm.elements.county_name.value = record.name;
                    recordForm.elements.badge_url.value = record.badgeUrl;
                }
            }

            dialog.showModal();
        }

        async function submitApiRequest(url, method, data = null) {
            try {
                const response = await fetch(url, {
                    method,
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                    body: data ? JSON.stringify(data) : null,
                });
                const result = await response.json();

                if (!response.ok) {
                    if (response.status === 401) {
                        sessionStorage.removeItem(tokenKey);
                        token = null;
                        updateAuthState();
                    }

                    const validationErrors = result.errors ? Object.values(result.errors).flat().join(' ') : '';
                    throw new Error(validationErrors || result.message || 'The request could not be completed.');
                }

                window.location.reload();
            } catch (error) {
                showMessage(error instanceof Error ? error.message : 'The request could not be completed.', true);
            }
        }

        loginForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            try {
                const response = await fetch(apiUrls.login, {
                    method: 'POST',
                    headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        email: loginForm.elements.email.value,
                        password: loginForm.elements.password.value,
                    }),
                });
                const result = await response.json();

                if (!response.ok || typeof result.user?.token !== 'string') {
                    throw new Error(result.message || 'Sign in failed.');
                }

                token = result.user.token;
                sessionStorage.setItem(tokenKey, token);
                updateAuthState();
                loginForm.reset();
                showMessage('Signed in. You can now manage records.');
            } catch (error) {
                showMessage(error instanceof Error ? error.message : 'Sign in failed.', true);
            }
        });

        logoutButton.addEventListener('click', () => {
            sessionStorage.removeItem(tokenKey);
            token = null;
            updateAuthState();
            showMessage('Signed out.');
        });

        document.querySelectorAll('[data-create]').forEach((button) => {
            button.addEventListener('click', () => openRecordDialog(button.dataset.create));
        });

        document.querySelectorAll('[data-edit]').forEach((button) => {
            button.addEventListener('click', () => openRecordDialog(button.dataset.edit, {
                id: button.dataset.id,
                name: button.dataset.name,
                zipCode: button.dataset.zipCode,
                population: button.dataset.population,
                countyId: button.dataset.countyId,
                badgeUrl: button.dataset.badgeUrl,
            }));
        });

        document.querySelectorAll('[data-delete]').forEach((button) => {
            button.addEventListener('click', () => {
                const cityCount = Number(button.dataset.cityCount || 0);
                const warning = button.dataset.delete === 'counties' && cityCount > 0
                    ? ` This will also delete ${cityCount} ${cityCount === 1 ? 'city' : 'cities'}.`
                    : '';

                if (window.confirm(`Delete ${button.dataset.name}?${warning}`)) {
                    submitApiRequest(`${apiUrls[button.dataset.delete]}/${button.dataset.id}`, 'DELETE');
                }
            });
        });

        document.querySelector('[data-close-dialog]').addEventListener('click', () => dialog.close());

        recordForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const data = activeResource === 'cities'
                ? {
                    name: recordForm.elements.city_name.value,
                    zip_code: Number(recordForm.elements.zip_code.value),
                    population: Number(recordForm.elements.population.value),
                    county_id: Number(recordForm.elements.county_id.value),
                }
                : {
                    name: recordForm.elements.county_name.value,
                    badge_url: recordForm.elements.badge_url.value,
                };
            const url = activeRecordId ? `${apiUrls[activeResource]}/${activeRecordId}` : apiUrls[activeResource];

            submitApiRequest(url, activeRecordId ? 'PUT' : 'POST', data);
        });

        updateAuthState();
    </script>
</body>
</html>
<?php /**PATH C:\Users\gergo\iskola\laravel_rest_api\resources\views/dashboard.blade.php ENDPATH**/ ?>