describe('Hot Wheels Market Tracker - Milestone 2', () => {

    const runId = Date.now();

    // Unique prices prevent duplicate pricing validation between runs.
    const submissionPrice =
        (300 + ((runId % 5000) / 100)).toFixed(2);

    const approvalPrice =
        (400 + ((runId % 5000) / 100)).toFixed(2);

    const rejectionPrice =
        (500 + ((runId % 5000) / 100)).toFixed(2);

    const testCarName = `Cypress M2 Car ${runId}`;
    const updatedCarName = `Cypress M2 Updated ${runId}`;


    before(() => {
        // Clear Laravel cache and previous login rate limits.
        cy.exec('php artisan cache:clear');

        // Recreate predictable Cypress test data.
        cy.exec('php artisan db:seed --class=CypressTestSeeder');
    });


    beforeEach(() => {
        // Use the desktop layout for Milestone 2 tests.
        // Admin pricing uses a desktop table at the lg breakpoint.
        cy.viewport(1440, 900);
    });


    // ============================================================
    // COLLECTOR SEARCH / FILTER
    // ============================================================

    it('allows a collector to search for a car by model', () => {
        loginCollector();

        cy.visit('/cars?model=Mazda');

        cy.contains('Mazda 787B')
            .should('be.visible');

        cy.contains('Factory Fresh')
            .should('be.visible');
    });


    it('allows a collector to filter cars by year and category', () => {
        loginCollector();

        cy.visit('/cars?year=2020&category=TH');

        cy.contains('Mazda 787B')
            .should('be.visible');

        cy.contains('2020')
            .should('exist');

        cy.contains('TH')
            .should('exist');
    });


    // ============================================================
    // CAR DETAILS
    // ============================================================

    it('allows a collector to view car details', () => {
        loginCollector();

        openMazdaCar();

        cy.contains('Mazda 787B')
            .should('be.visible');

        cy.contains('Factory Fresh')
            .should('be.visible');

        cy.contains('TH')
            .should('exist');

        cy.location('pathname')
            .should('match', /^\/cars\/\d+$/);
    });


    // ============================================================
    // FAVORITES
    // ============================================================

    it('allows a collector to remove a saved favorite', () => {
        loginCollector();

        openMazdaCar();

        /*
         * Find the DELETE favorite form.
         *
         * If the car is not currently saved, save it first so this
         * test always starts from a predictable state.
         */
        cy.get('body').then(($body) => {

            const deleteFavoriteForm = $body
                .find('form[action*="/favorite"]')
                .filter(function () {
                    return Cypress.$(this)
                        .find(
                            'input[name="_method"][value="DELETE"]'
                        )
                        .length > 0;
                });

            if (deleteFavoriteForm.length === 0) {

                cy.get('form[action*="/favorite"]')
                    .first()
                    .find('button[type="submit"]')
                    .should('be.visible')
                    .click();

                cy.location('pathname')
                    .should('match', /^\/cars\/\d+$/);
            }
        });


        // A DELETE favorite form should now exist.
        cy.get('form[action*="/favorite"]')
            .filter(function () {
                return Cypress.$(this)
                    .find(
                        'input[name="_method"][value="DELETE"]'
                    )
                    .length > 0;
            })
            .should('exist')
            .first()
            .find('button[type="submit"]')
            .should('be.visible')
            .click();


        // After removal, the DELETE form should disappear.
        cy.get('form[action*="/favorite"]')
            .filter(function () {
                return Cypress.$(this)
                    .find(
                        'input[name="_method"][value="DELETE"]'
                    )
                    .length > 0;
            })
            .should('not.exist');


        // Restore the seeded favorite for later tests.
        cy.exec('php artisan db:seed --class=CypressTestSeeder');
    });


    // ============================================================
    // PRICE SUBMISSION
    // ============================================================

    it('allows a collector to submit pricing for review', () => {
        loginCollector();

        openMazdaCar();

        fillPriceSubmission(submissionPrice);

        submitPricingForm();

        cy.location('pathname', { timeout: 10000 })
            .should('match', /^\/cars\/\d+$/);

        cy.get('body')
            .invoke('text')
            .should('match', /pending|approval|submitted|success/i);
    });


    // ============================================================
    // ROLE-BASED ACCESS CONTROL
    // ============================================================

    it('prevents a collector from accessing the admin area', () => {
        loginCollector();

        cy.request({
            method: 'GET',
            url: '/admin',
            failOnStatusCode: false,
        }).then((response) => {
            expect(response.status).to.eq(403);
        });
    });


    // ============================================================
    // ADMIN DASHBOARD
    // ============================================================

    it('allows an administrator to access the admin dashboard', () => {
        loginAdmin();

        cy.visit('/admin');

        cy.location('pathname')
            .should('eq', '/admin');

        cy.contains('Administrator')
            .should('exist');

        cy.contains('Manage Cars')
            .should('exist');

        cy.contains('Pricing')
            .should('exist');
    });


    // ============================================================
    // ADMIN CAR CRUD
    // ============================================================

    it('allows an administrator to create, edit, and delete a car', () => {
        loginAdmin();


        // --------------------------------------------------------
        // CREATE
        // --------------------------------------------------------

        cy.visit('/admin/cars/create');

        cy.get('input[name="model_name"]')
            .should('be.visible')
            .type(testCarName);

        cy.get('input[name="series_name"]')
            .should('be.visible')
            .type('Cypress Test Series');

        cy.get('input[name="release_year"]')
            .should('be.visible')
            .type('2026');

        cy.get('select[name="category"]')
            .should('be.visible')
            .select('TH');

        cy.get('textarea[name="description"]')
            .should('be.visible')
            .type(
                'Car created automatically by the Milestone 2 Cypress test.'
            );

        cy.contains('button', 'Add Car')
            .should('be.visible')
            .click();

        cy.location('pathname', { timeout: 10000 })
            .should('eq', '/admin/cars');

        cy.contains(testCarName)
            .should('be.visible');


        // --------------------------------------------------------
        // EDIT
        // --------------------------------------------------------

        cy.contains('article', testCarName)
            .should('be.visible')
            .within(() => {

                cy.contains('Edit')
                    .should('be.visible')
                    .click();

            });

        cy.get('input[name="model_name"]')
            .should('be.visible')
            .clear()
            .type(updatedCarName);

        cy.get('textarea[name="description"]')
            .should('be.visible')
            .clear()
            .type(
                'Updated by Cypress Milestone 2 testing.'
            );

        cy.contains('button', 'Save Changes')
            .should('be.visible')
            .click();

        cy.location('pathname', { timeout: 10000 })
            .should('eq', '/admin/cars');

        cy.contains(updatedCarName)
            .should('be.visible');


        // --------------------------------------------------------
        // DELETE
        // --------------------------------------------------------

        cy.on('window:confirm', () => true);

        cy.contains('article', updatedCarName)
            .should('be.visible')
            .within(() => {

                cy.contains('button', 'Delete')
                    .should('be.visible')
                    .click();

            });

        cy.contains(updatedCarName)
            .should('not.exist');
    });


    // ============================================================
    // ADMIN PRICE APPROVAL
    // ============================================================

    it('allows an administrator to approve pending pricing', () => {

        // Create a unique pending submission as collector.
        loginCollector();

        openMazdaCar();

        fillPriceSubmission(approvalPrice);

        submitPricingForm();

        cy.location('pathname', { timeout: 10000 })
            .should('match', /^\/cars\/\d+$/);


        // Switch from collector to administrator.
        logoutCurrentSession();

        loginAdmin();

        cy.visit('/admin/pricing');

        cy.contains('Pending Price Submissions')
            .should('be.visible');


        const formattedPrice =
            `$${Number(approvalPrice).toFixed(2)}`;


        cy.contains('tr', formattedPrice, {
            timeout: 10000,
        })
            .should('be.visible')
            .within(() => {

                cy.contains('Pending Approval')
                    .should('be.visible');

                cy.contains('button', 'Approve')
                    .should('be.visible')
                    .click();

            });


        // Approved submission should leave the pending list.
        cy.contains('tr', formattedPrice)
            .should('not.exist');
    });


    // ============================================================
    // ADMIN PRICE REJECTION
    // ============================================================

    it('allows an administrator to reject pending pricing', () => {

        // Create another unique pending submission.
        loginCollector();

        openMazdaCar();

        fillPriceSubmission(rejectionPrice);

        submitPricingForm();

        cy.location('pathname', { timeout: 10000 })
            .should('match', /^\/cars\/\d+$/);


        // Switch to administrator.
        logoutCurrentSession();

        loginAdmin();

        cy.visit('/admin/pricing');

        cy.on('window:confirm', () => true);


        const formattedPrice =
            `$${Number(rejectionPrice).toFixed(2)}`;


        cy.contains('tr', formattedPrice, {
            timeout: 10000,
        })
            .should('be.visible')
            .within(() => {

                cy.contains('Pending Approval')
                    .should('be.visible');

                cy.contains('button', 'Reject')
                    .should('be.visible')
                    .click();

            });


        // Rejected submission should leave the pending list.
        cy.contains('tr', formattedPrice)
            .should('not.exist');
    });

});


/**
 * Create or restore an authenticated collector session.
 *
 * cy.session avoids repeatedly hitting the login endpoint and
 * triggering Laravel/Fortify login throttling.
 */
function loginCollector() {

    cy.session('milestone2-collector', () => {

        cy.visit('/login');

        cy.get('[data-test="login-button"]', {
            timeout: 10000,
        }).should('be.visible');

        cy.get('input[name="email"]')
            .should('be.visible')
            .should('have.value', '')
            .type('cypress@example.com');

        cy.get('input[name="password"]')
            .should('be.visible')
            .type('password', {
                log: false,
            });

        cy.get('[data-test="login-button"]')
            .should('be.enabled')
            .click();

        cy.location('pathname', {
            timeout: 10000,
        }).should('eq', '/dashboard');

    }, {

        validate() {

            cy.request({
                url: '/dashboard',
                failOnStatusCode: false,
            })
                .its('status')
                .should('eq', 200);

        },

    });
}


/**
 * Create or restore an authenticated administrator session.
 */
function loginAdmin() {

    cy.session('milestone2-admin', () => {

        cy.visit('/login');

        cy.get('[data-test="login-button"]', {
            timeout: 10000,
        }).should('be.visible');

        cy.get('input[name="email"]')
            .should('be.visible')
            .should('have.value', '')
            .type('admin@test.com');

        cy.get('input[name="password"]')
            .should('be.visible')
            .type('password', {
                log: false,
            });

        cy.get('[data-test="login-button"]')
            .should('be.enabled')
            .click();

        cy.location('pathname', {
            timeout: 10000,
        }).should('eq', '/dashboard');

    }, {

        validate() {

            cy.request({
                url: '/admin',
                failOnStatusCode: false,
            })
                .its('status')
                .should('eq', 200);

        },

    });
}


/**
 * Clear the active browser login.
 *
 * This allows another cached cy.session account to be restored.
 */
function logoutCurrentSession() {
    cy.clearCookies();
    cy.clearLocalStorage();
}


/**
 * Open the seeded Mazda 787B collector detail page.
 */
function openMazdaCar() {

    cy.visit('/cars');

    cy.contains('article', 'Mazda 787B', {
        timeout: 10000,
    })
        .should('be.visible')
        .within(() => {

            cy.contains('View Details')
                .should('be.visible')
                .click();

        });

    cy.location('pathname', {
        timeout: 10000,
    }).should('match', /^\/cars\/\d+$/);
}


/**
 * Fill the collector price submission form.
 */
function fillPriceSubmission(price) {

    // Use yesterday so future-date validation can never fail.
    const yesterday = new Date(
        Date.now() - (24 * 60 * 60 * 1000)
    )
        .toISOString()
        .slice(0, 10);


    cy.get('input[name="price"]')
        .should('be.visible')
        .clear()
        .type(price);


    /*
     * Currency may be represented by either a select or
     * text input depending on the current form design.
     */
    cy.get('body').then(($body) => {

        if (
            $body.find('select[name="currency"]').length > 0
        ) {

            cy.get('select[name="currency"]')
                .should('be.visible')
                .select('CAD');

        } else {

            cy.get('input[name="currency"]')
                .should('be.visible')
                .clear()
                .type('CAD');

        }

    });


    cy.get('input[name="submission_date"]')
        .should('be.visible')
        .clear()
        .type(yesterday);


    /*
     * Fill source_type only if the form currently exposes it.
     */
    cy.get('body').then(($body) => {

        if (
            $body.find('select[name="source_type"]').length > 0
        ) {

            cy.get('select[name="source_type"]')
                .then(($select) => {

                    const options =
                        $select.find('option');

                    if (options.length > 1) {

                        cy.wrap($select)
                            .select(
                                options.eq(1).val()
                            );

                    }

                });

        } else if (
            $body.find('input[name="source_type"]').length > 0
        ) {

            cy.get('input[name="source_type"]')
                .should('be.visible')
                .clear()
                .type('Cypress Test');

        }

    });
}


/**
 * Submit the collector pricing form.
 */
function submitPricingForm() {

    cy.get('form[action*="/pricing"]')
        .should('exist')
        .first()
        .find('button[type="submit"]')
        .should('be.visible')
        .click();

}