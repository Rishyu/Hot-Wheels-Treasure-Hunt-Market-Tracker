describe('Hot Wheels Market Tracker - Milestone 1', () => {

    before(() => {
        // Clear previous Laravel login rate limits.
        cy.exec('php artisan cache:clear');

        // Recreate predictable Cypress test data.
        cy.exec('php artisan db:seed --class=CypressTestSeeder');
    });

    it('allows a collector to log in', () => {
        cy.visit('/login');

        // Wait until the redesigned login form is fully rendered.
        cy.get('[data-test="login-button"]', { timeout: 10000 })
            .should('be.visible');

        cy.get('input[name="email"]', { timeout: 10000 })
            .should('be.visible')
            .should('have.value', '')
            .type('postmancollector@example.com');

        cy.get('input[name="password"]')
            .should('be.visible')
            .type('password', { log: false });

        cy.get('[data-test="login-button"]')
            .should('be.enabled')
            .click();

        cy.location('pathname', { timeout: 10000 })
            .should('eq', '/dashboard');

        // Confirm that the authenticated page finished loading.
        cy.get('body')
            .should('be.visible');
    });

    it('allows a collector to view their profile', () => {
        login();

        cy.visit('/settings/profile');

        cy.contains('Profile')
            .should('exist');

        cy.contains('Saved Favorites')
            .should('be.visible');
    });

    it('allows a collector to update their username', () => {
        login();

        cy.visit('/settings/profile');

        cy.get('input[autocomplete="username"]')
            .should('be.visible')
            .clear()
            .type('cypresscollector');

        cy.get('[data-test="update-profile-button"]')
            .should('be.visible')
            .click();

        cy.get('input[autocomplete="username"]')
            .should('have.value', 'cypresscollector');
    });

    it('shows saved favorite cars', () => {
        login();

        cy.visit('/settings/profile');

        cy.contains('Saved Favorites')
            .should('be.visible');

        cy.contains('Mazda 787B')
            .should('be.visible');

        cy.contains('Factory Fresh')
            .should('be.visible');

        cy.contains('2020')
            .should('be.visible');

        cy.contains('TH')
            .filter(':visible')
            .should('exist');
    });

    it('rejects an invalid password', () => {
        cy.visit('/login');

        cy.get('[data-test="login-button"]', { timeout: 10000 })
            .should('be.visible');

        cy.get('input[name="email"]')
            .should('be.visible')
            .should('have.value', '')
            .type('cypress@example.com');

        cy.get('input[name="password"]')
            .should('be.visible')
            .type('wrongpassword', { log: false });

        cy.get('[data-test="login-button"]')
            .click();

        cy.location('pathname', { timeout: 10000 })
            .should('eq', '/login');
    });
});


/**
 * Log in using the dedicated Cypress collector account.
 */
function login() {
    cy.visit('/login');

    // Wait for the redesigned login page to finish rendering.
    cy.get('[data-test="login-button"]', { timeout: 10000 })
        .should('be.visible');

    cy.get('input[name="email"]')
        .should('be.visible')
        .should('have.value', '')
        .type('cypress@example.com');

    cy.get('input[name="password"]')
        .should('be.visible')
        .type('password', { log: false });

    cy.get('[data-test="login-button"]')
        .should('be.enabled')
        .click();

    cy.location('pathname', { timeout: 10000 })
        .should('eq', '/dashboard');
}