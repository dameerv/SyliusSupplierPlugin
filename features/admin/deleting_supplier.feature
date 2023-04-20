@managing_suppliers
Feature: Deleting a supplier
    In order to delete a brand
    As an Administrator
    I want to be able to delete a supplier

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And there is an existing supplier with "Test" name

    @ui
    Scenario: Deleting a supplier
        When I go to the suppliers page
        And I delete the supplier "Test"
        Then I should be notified that it has been successfully deleted
