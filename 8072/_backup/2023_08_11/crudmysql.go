package main

import (
	"database/sql"
	"fmt"
	"html/template"
	"log"
	"net/http"
	"strconv"

	"github.com/labstack/echo"
	_ "github.com/go-sql-driver/mysql"
)

type User struct {
	ID    int
	Name  string
	Email string
}

func main() {
	e := echo.New()

	// Set template engine
	renderer := &TemplateRenderer{
		templates: template.Must(template.ParseGlob("templates/*.html")),
	}
	e.Renderer = renderer

	// Routes
	e.GET("/", getUsers)
	e.GET("/users/new", showNewUserForm)
	e.POST("/users", createUser)
	e.GET("/users/:id/edit", showEditUserForm)
	e.POST("/users/:id", updateUser)
	e.DELETE("/users/:id", deleteUser)

	// Start server
	e.Start(":8080")
}

// TemplateRenderer is a custom renderer for Echo framework
type TemplateRenderer struct {
	templates *template.Template
}

// Render renders the templates
func (t *TemplateRenderer) Render(w http.ResponseWriter, name string, data interface{}, c echo.Context) error {
	return t.templates.ExecuteTemplate(w, name, data)
}

// Database connection
func dbConn() (db *sql.DB) {
	dbDriver := "mysql"
	dbUser := "root"
	dbPass := "password"
	dbName := "test"
	db, err := sql.Open(dbDriver, dbUser+":"+dbPass+"@/"+dbName)
	if err != nil {
		log.Fatal(err)
	}
	return db
}

// Handlers
func getUsers(c echo.Context) error {
	db := dbConn()
	defer db.Close()

	rows, err := db.Query("SELECT * FROM users ORDER BY id DESC")
	if err != nil {
		log.Fatal(err)
	}

	var users []User

	for rows.Next() {
		var user User
		err = rows.Scan(&user.ID, &user.Name, &user.Email)
		if err != nil {
			log.Fatal(err)
		}
		users = append(users, user)
	}

	return c.Render(http.StatusOK, "index.html", users)
}

func showNewUserForm(c echo.Context) error {
	return c.Render(http.StatusOK, "new.html", nil)
}

func createUser(c echo.Context) error {
	db := dbConn()
	defer db.Close()

	name := c.FormValue("name")
	email := c.FormValue("email")

	_, err := db.Exec("INSERT INTO users (name, email) VALUES (?, ?)", name, email)
	if err != nil {
		log.Fatal(err)
	}

	return c.Redirect(http.StatusSeeOther, "/")
}

func showEditUserForm(c echo.Context) error {
	db := dbConn()
	defer db.Close()

	id, _ := strconv.Atoi(c.Param("id"))

	var user User

	err := db.QueryRow("SELECT * FROM users WHERE id=?", id).Scan(&user.ID, &user.Name, &user.Email)
	if err != nil {
		log.Fatal(err)
	}

	return c.Render(http.StatusOK, "edit.html", user)
}

func updateUser(c echo.Context) error {
	db := dbConn()
	defer db.Close()

	id, _ := strconv.Atoi(c.Param("id"))
	name := c.FormValue("name")
	email := c.FormValue("email")

	_, err := db.Exec("UPDATE users SET name=?, email=? WHERE id=?", name, email, id)
	if err != nil {
		log.Fatal(err)
	}

	return c.Redirect(http.StatusSeeOther, "/")
}

func deleteUser(c echo.Context) error {
	db := dbConn()
	defer db.Close()

	id, _ := strconv.Atoi(c.Param("id"))

	_, err := db.Exec("DELETE FROM users WHERE id=?", id)
	if err != nil {
		log.Fatal(err)
	}

	return c.JSON(http.StatusOK, map[string]interface{}{
		"message": "User deleted successfully",
	})
}
