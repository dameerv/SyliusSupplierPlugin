@shop_suppliers
Feature: Browsing brands
    In order to show different brands
    As a Customer
    I want to browse suppliers

    Background:
        Given the store operates on a single channel in "United States"
        And the store has 10 suppliers

    @ui
    Scenario: Browsing suppliers
        When I want to list suppliers
        Then I should see 10 suppliers on the page
