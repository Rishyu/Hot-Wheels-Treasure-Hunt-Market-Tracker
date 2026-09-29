describe('Hot Wheels Market Tracker - Milestone 1', () => {

    before(() => {
        // Clear previous Laravel login rate limits.
        cy.exec('php artisan cache:clear');

        // Recreate predictable Cypress test data.
        cy.exec('php artisan db:seed --class=CypressTestSeeder');
    });

    it('allows a collector to log in', () => {
        login();

        cy.location('pathname')
            .should('eq', '/dashboard');
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
            .clear()
            .type('cypresscollector');

        cy.get('[data-test="update-profile-button"]')
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
            .should('be.visible');
    });

    it('rejects an invalid password', () => {
        cy.visit('/login');

        cy.get('input[name="email"]')
            .should('be.visible')
            .type('cypress@example.com');

        cy.get('input[name="password"]')
            .should('be.visible')
            .type('wrongpassword');

        cy.get('button[type="submit"]')
            .click();

        cy.location('pathname')
            .should('eq', '/login');
    });
});


/**
 * Log in using the dedicated Cypress collector account.
 */
function login() {
    cy.visit('/login');

    cy.get('input[name="email"]')
        .should('be.visible')
        .clear()
        .type('cypress@example.com');

    cy.get('input[name="password"]')
        .should('be.visible')
        .clear()
        .type('password');

    cy.get('button[type="submit"]')
        .click();

    cy.location('pathname', { timeout: 10000 })
        .should('eq', '/dashboard');
}