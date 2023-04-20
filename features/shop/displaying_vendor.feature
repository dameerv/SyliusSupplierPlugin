@shop_suppliers
Feature: Displaying brands
    In order to read store information
    As a Customer
    I want to display suppliers

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Displaying supplier
        Given there is an existing supplier with "Test" name
        And this supplier has "iPhone 8" and "iPhone X" products associated with it
        When I go to the "test" page
        Then I should see a page with "Test" name
