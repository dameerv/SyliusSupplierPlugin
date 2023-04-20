@managing_suppliers
Feature: Browsing suppliers
    In order to show different brands
    As an Administrator
    I want to be able to browse suppliers

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And the store has 5 suppliers

    @ui
    Scenario: Browsing defined suppliers
        When I want to browse suppliers
        Then I should see 5 suppliers in the list
